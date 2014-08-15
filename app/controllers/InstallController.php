<?php

class InstallController extends BaseController {

    /**
     * @var Path to june
     */
    public $sourceDir;

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
     * @var Cloud update package infomation
     */
    public $cloudInfo;


    /**
     * Constructor
     */
    public function __construct()
    {
        $clientDir = 'cloud';
        $this->sourceDir = app('path.cloud');
        $this->destinationDir = app_path($clientDir);
        $this->migratePath = 'sample/app/'.$clientDir.'/migrations';
        $this->remotePath = 'http://tp1club.com/juneupdate';
    }
    public function install()
    {

    }
	public function update()
	{
        if($this->checkUpdate()){
            $this->updateCloudToClient();
        }
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

    protected function updateCloudToClient()
    {
        $remoteFile = 'latest.zip';
        $saveAs = storage_path('tmp/' . $remoteFile);
        $this->downloadFile($remoteFile,$saveAs);
        Zipper::make($saveAs)->folder('cloud')->extractTo($this->destinationDir);
        CMS::storePut('version',$this->getCloudVersion());
    }

    /**
     * Call artisan to run migrate kiss mysql
     *
     * @return mixed
     */
    protected function runMysql()
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
