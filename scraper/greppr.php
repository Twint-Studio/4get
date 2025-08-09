<?php

class greppr{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("greppr");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		return [];
	}
	
	private function get($proxy, $url, $get = [], $cookie = false, $post){
		
		$curlproc = curl_init();
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		
		if($post === false){
						
			if($get !== []){
				$get = http_build_query($get);
				$url .= "?" . $get;
			}
			
			if($cookie === false){
				
				curl_setopt($curlproc, CURLOPT_HTTPHEADER,
					["User-Agent: " . config::USER_AGENT,
					"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip",
					"DNT: 1",
					"Connection: keep-alive",
					"Upgrade-Insecure-Requests: 1",
					"Sec-Fetch-Dest: document",
					"Sec-Fetch-Mode: navigate",
					"Sec-Fetch-Site: none",
					"Sec-Fetch-User: ?1"]
				);
			}else{
				
				curl_setopt($curlproc, CURLOPT_HTTPHEADER,
					["User-Agent: " . config::USER_AGENT,
					"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip, deflate, br, zstd",
					"DNT: 1",
					"Sec-GPC: 1",
					"Connection: keep-alive",
					"Referer: https://greppr.org/search",
					"Cookie: PHPSESSID=$cookie",
					"Upgrade-Insecure-Requests: 1",
					"Sec-Fetch-Dest: document",
					"Sec-Fetch-Mode: navigate",
					"Sec-Fetch-Site: same-origin",
					"Sec-Fetch-User: ?1",
					"Priority: u=0, i"]
				);
			}
		}else{
			
			$get = http_build_query($get);
			
			curl_setopt($curlproc, CURLOPT_POST, true);
			curl_setopt($curlproc, CURLOPT_POSTFIELDS, $get);
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip, deflate, br, zstd",
				"Content-Type: application/x-www-form-urlencoded",
				"Content-Length: " . strlen($get),
				"Origin: https://greppr.org",
				"DNT: 1",
				"Sec-GPC: 1",
				"Connection: keep-alive",
				"Referer: https://greppr.org/",
				"Cookie: PHPSESSID=$cookie",
				"Upgrade-Insecure-Requests: 1",
				"Sec-Fetch-Dest: document",
				"Sec-Fetch-Mode: navigate",
				"Sec-Fetch-Site: same-origin",
				"Sec-Fetch-User: ?1",
				"Priority: u=0, i"]
			);
		}
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);
		
		$this->backend->assign_proxy($curlproc, $proxy);
		
		$headers = [];
		
		curl_setopt(
			$curlproc,
			CURLOPT_HEADERFUNCTION,
			function($curlproc, $header) use (&$headers){
				
				$len = strlen($header);
				$header = explode(':', $header, 2);
				
				if(count($header) < 2){
					
					// ignore invalid headers
					return $len;
				}
				
				$headers[strtolower(trim($header[0]))] = trim($header[1]);

				return $len;
			}
		);
				
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		
		return [
			"headers" => $headers,
			"data" => $data
		];
	}
	
	public function web($get, $first_attempt = true){
		
		if($get["npt"]){
			
			[$q, $proxy] = $this->backend->get($get["npt"], "web");
			
			$tokens = json_decode($q, true);
			
			//
			// Get paginated page
			//
			try{
			
				$html = $this->get(
					$proxy,
					"https://greppr.org" . $tokens["get"],
					[],
					$tokens["cookie"],
					false
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			
			//
			// get token
			//
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://greppr.org",
						[],
						false,
						false
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search tokens");
			}
			
			//
			// Parse token
			//
			$this->fuckhtml->load($html["data"]);
		
			$tokens = [];
			
			$inputs =
				$this->fuckhtml
				->getElementsByTagName(
					"input"
				);
				
			foreach($inputs as $input){
				
				if(!isset($input["attributes"]["name"])){
					
					continue;
				}
				
				switch($input["attributes"]["name"]){
					
					case "var1":
					case "var2":
					case "n":
						$tokens[$input["attributes"]["name"]] =
							$this->fuckhtml
							->getTextContent(
								$input["attributes"]["value"]
							);
						break;
					
					default:
						$tokens["req"] =
							$this->fuckhtml
							->getTextContent(
								$input["attributes"]["name"]
							);
						break;
				}
			}
			
			// get cookie
			preg_match(
				'/PHPSESSID=([^;]+)/',
				$html["headers"]["set-cookie"],
				$cookie
			);
			
			if(!isset($cookie[1])){
				
				// server sent an unexpected cookie
				throw new Exception("Got malformed cookie");
			}
			
			$tokens["cookie"] = $cookie[1];
			
			if($tokens === false){
				
				throw new Exception("Failed to grep search tokens");
			}
			
			//
			// Get initial search page
			//
			try{
			
				$html = $this->get(
					$proxy,
					"https://greppr.org/search",
					[
						"var1" => $tokens["var1"],
						"var2" => $tokens["var2"],
						$tokens["req"] => $search,
						"n" => $tokens["n"]
					],
					$tokens["cookie"],
					true
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
		}
		
		//$html = file_get_contents("scraper/greppr.html");
		//$this->fuckhtml->load($html);
		$this->fuckhtml->load($html["data"]);
		
		$out = [
			"status" => "ok",
			"spelling" => [
				"type" => "no_correction",
				"using" => null,
				"correction" => null
			],
			"npt" => null,
			"answer" => [],
			"web" => [],
			"image" => [],
			"video" => [],
			"news" => [],
			"related" => []
		];
		
		// get results for later
		$results =
			$this->fuckhtml
			->getElementsByClassName(
				"result",
				"div"
			);
		
		// check for next page
		$next_elem =
			$this->fuckhtml
			->getElementsByClassName(
				"pagination",
				"ul"
			);
		
		if(count($next_elem) !== 0){
			
			$this->fuckhtml->load($next_elem[0]);
			
			$as =
				$this->fuckhtml
				->getElementsByClassName(
					"page-link",
					"a"
				);
			
			$break = false;
			foreach($as as $a){
				
				if($break === true){
					
					$out["npt"] =
						$this->backend->store(
							json_encode([
								"get" =>
									$this->fuckhtml
									->getTextContent(
										$a["attributes"]["href"]
									),
								"cookie" => $tokens["cookie"]
							]),
							"web",
							$proxy
						);
					break;
				}
				
				if($a["attributes"]["href"] == "#"){
					
					$break = true;
				}
			}
		}
		
		// scrape results
		foreach($results as $result){
			
			$this->fuckhtml->load($result);
			
			$a =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				)[0];
			
			$description =
				$this->fuckhtml
				->getElementsByClassName(
					"highlightedDesc",
					"p"
				);
			
			if(count($description) === 0){
				
				$description = null;
			}else{
				
				$description =
					$this->limitstrlen(
						$this->fuckhtml
						->getTextContent(
							$description[0]
						)
					);
			}
			
			$date =
				$this->fuckhtml
				->getElementsByTagName(
					"p"
				);
			
			$date =
				strtotime(
					explode(
						":",
						$this->fuckhtml
						->getTextContent(
							$date[count($date) - 1]["innerHTML"]
						)
					)[1]
				);
			
			$out["web"][] = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$a["innerHTML"]
					),
				"description" => $description,
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$a["attributes"]["href"]
					),
				"date" => $date,
				"type" => "web",
				"thumb" => [
					"url" => null,
					"ratio" => null
				],
				"sublink" => [],
				"table" => []
			];
		}
		
		return $out;
	}
	
	private function limitstrlen($text){
		
		return explode("\n", wordwrap($text, 300, "\n"))[0];
	}
}
