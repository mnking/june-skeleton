<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>June CMS</title>
    {{ HTML::getBootstrap() }}
	<style>

		.welcome {
            width: 508px;
            margin: 100px auto;
		}

	</style>
</head>
<body>
	<div class="welcome">
		<a href="#" title="June CMS"><img src="{{ June::asset('june.png') }}" alt="June CMS"></a>
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Thông tin Database
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('host', 'Host'); }}
                            {{ Form::text('host','localhost',array('class'=>'form-control')); }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('username', 'Username'); }}
                            {{ Form::text('username','',array('class'=>'form-control')); }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password'); }}
                            {{ Form::password('password',array('class'=>'form-control')); }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('database', 'Database'); }}
                            {{ Form::text('database','',array('class'=>'form-control')); }}
                        </div>
                    </div>
                    <div class="panel-footer clearfix">
                        {{ Form::button('Tiếp Tục',array('class'=>'btn btn-primary pull-right')); }}
                    </div>
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Thông tin đăng nhập
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('username', 'Username'); }}
                            {{ Form::text('username','',array('class'=>'form-control')); }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password'); }}
                            {{ Form::password('password',array('class'=>'form-control')); }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('repassword', 'Re-Password'); }}
                            {{ Form::password('repassword',array('class'=>'form-control')); }}
                        </div>
                    </div>
                    <div class="panel-footer clearfix">
                        {{ Form::button('Tiếp Tục',array('class'=>'btn btn-primary pull-right')); }}
                        {{ Form::button('Lùi Lại',array('class'=>'btn btn-default')); }}
                    </div>
                </div>
            </div>
		</div>
	</div>
    {{ HTML::getJquery() }}
    {{ HTML::getBootstrap('script') }}
</body>
</html>
