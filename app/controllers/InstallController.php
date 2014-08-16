<?php

class InstallController extends BaseController {

    /**
     * @var Path to client update
     */
    public $destinationDir;

    /**
     * @var Path to migrate folder
     */
    public $migratePath;

    /**
     * @var Remote path. Get update file in it
     */
    public $remotePath;

    /**
     * @var Cloud update package information
     */
    public $cloudInfo;

    /**
     * @var Package information
     */
    public $infoFile;


    /**
     * Constructor
     */
    public function __construct()
    {
        $clientDir = 'cloud';
        $this->destinationDir = app_path($clientDir);
        $this->migratePath = 'sample/app/'.$clientDir.'/migrations';
        $this->remotePath = 'http://tp1club.com/juneupdate';
        $this->infoFile = 'info.json';
    }
    public function install()
    {

    }

    /**
     * Run update to application
     */
    public function update()
	{
        if($this->checkUpdate()){
            $this->updateCloudToClient();
        }
	}

    public function checkInstallDatabase()
    {
        if(DB::connection()->getDatabaseName()){
            $check = DB::select(DB::raw('SELECT COUNT(*) as cnt
                FROM information_schema.tables
                WHERE table_name IN ("cms")
                AND table_schema = database()'));
            if($check[0]->cnt)
            {
               if(CMS::storeGet('installed') == 1){
                   return true;
               }
            }
        }
        return false;
    }

    public function checkInstallPackage()
    {
        $path = $this->destinationDir . $this->infoFile;
        return File::exists($path);
    }

    public function completeInstall()
    {
        return View::make('install');
    }

    /**
     * Check if has update. Check by version of cloud and client
     *
     * @return bool
     */
    public function checkUpdate()
    {
        return ($this->getCloudVersion() !== CMS::storeGet('version'));
    }

    /**
     * Delete file in client but do not exists in cloud
     *
     * @return mixed
     */
    protected function deleteFileNotInCloud()
    {
        $files = File::allFiles($this->destinationDir);
        $fileNeedToDelete = array();
        foreach ($files as $file)
        {
            $file = (string)$file;
            $localFile = str_replace($this->destinationDir,$this->sourceDir,$file);
            if (!File::isFile($localFile))
            {
                $fileNeedToDelete[] = $file;
            }
        }
        return File::delete($fileNeedToDelete);
    }

    /**
     * Download update file,package info and extract it to client
     */
    protected function updateCloudToClient()
    {
        $remoteFile = 'latest.zip';
        $saveAs = storage_path('tmp/' . $remoteFile);
        $this->downloadFile($remoteFile,$saveAs);
        Zipper::make($saveAs)->folder('cloud')->extractTo($this->destinationDir);
        $this->downloadFile($this->infoFile,$this->destinationDir);
    }

    /**
     * Call artisan to run migrate kiss mysql
     *
     * @return mixed
     */
    protected function runMigrate()
    {
        return Artisan::call('migrate',array('--path'=>$this->migratePath));
    }

    /**
     * Call Artisan to run seeder add sample data to database
     *
     * @return mixed
     */
    protected function runSeeder()
    {
        return Artisan::call('migrate',array('--path'=>$this->migratePath));
    }

    /**
     * Download file and save it
     *
     * @param $path
     * @param $saveTo
     * @return int
     */
    protected function downloadFile($path,$saveTo)
    {
        $path = $this->remotePath . '/' . $path;
        $data = file_get_contents($path);
        return file_put_contents($saveTo,$data);
    }

    /**
     * Get remote cloud info
     *
     * @return object
     */
    protected function getCloudInfo()
    {
        $path = $this->remotePath . '/info.json';
        if(!$this->cloudInfo){
            $this->cloudInfo = file_get_contents($path);
        }
        return json_decode($this->cloudInfo);
    }

    /**
     * Get remote cloud update version
     *
     * @return mixed
     */
    protected function getCloudVersion()
    {
        return $this->getCloudInfo()->version;
    }


}
