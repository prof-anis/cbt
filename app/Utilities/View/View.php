<?php
/**
 * 
 */

namespace App\Utilities\View;

class View 
{
	protected $viewPath = __DIR__."/../../../resources/views";
	protected $storagePath = __DIR__."/../../../resources/storage";
	protected $configPath = __DIR__.'/../../../config';


	function __construct()
	{
		
	}

	public function show($view,array $options = []){
		extract($options);
		if (file_exists($this->viewPath."/".$view.".php")) {
			$template = $this->loadFile($view);
			require $this->storagePath."/".$template;
		}
		else{
			throw new \Exception("$view not found", 1);
			
		}

	}
	
	public function loadFile($view){
		
		if (config('view.cache')== false) {
			return $this->openAndReplaceFile($view)[0];
		}elseif(config('view.cache') == true){
			//Still needs adjustments
			return $this->openAndReplaceFile($view)[0];
		}
	}
	public function openAndReplaceFile($view){
			$template = $this->viewPath."/".$view.".php";
			$whole_file = file_get_contents($template);
			$whole_file = str_replace("{{","<?php echo ",$whole_file);
			$whole_file = str_replace("}}","; ?>",$whole_file);
			$file_name = md5($template);
			$file_name.=".php";
			$file_path = $this->storagePath."/".$file_name;
	
			$fp = fopen($file_path, "w+");
			fwrite($fp, $whole_file);
			fclose($fp);
			return [$file_name];

	}
	public static function asset($url){
		$server_host = request()->server('HTTP_HOST');
		return "http://$server_host/project/resources/assets/".$url;
	}

}