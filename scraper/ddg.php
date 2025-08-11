<?php

class ddg{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("ddg");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	/*
		curl functions
	*/
	private const req_web = 0;
	private const req_xhr = 1;
	
	private function get($proxy, $url, $get = [], $reqtype = self::req_web){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		// http2 bypass
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
		switch($reqtype){
			case self::req_web:
				$headers =
					["User-Agent: " . config::USER_AGENT,
					"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip",
					"DNT: 1",
					"Sec-GPC: 1",
					"Connection: keep-alive",
					"Upgrade-Insecure-Requests: 1",
					"Sec-Fetch-Dest: document",
					"Sec-Fetch-Mode: navigate",
					"Sec-Fetch-Site: same-origin",
					"Sec-Fetch-User: ?1",
					"Priority: u=0, i",
					"TE: trailers"];
				break;
			
			case self::req_xhr:
				$headers =
					["User-Agent: " . config::USER_AGENT,
					"Accept: */*",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip",
					"Referer: https://duckduckgo.com/",
					"DNT: 1",
					"Sec-GPC: 1",
					"Connection: keep-alive",
					"Sec-Fetch-Dest: script",
					"Sec-Fetch-Mode: no-cors",
					"Sec-Fetch-Site: same-site",
					"Priority: u=1"];
				break;
		}
		
		$this->backend->assign_proxy($curlproc, $proxy);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function getfilters($pagetype){
		
		$base = [
			"country" => [
				"display" => "Country",
				"option" => [
					"us-en" => "US (English)",
					"ar-es" => "Argentina",
					"au-en" => "Australia",
					"at-de" => "Austria",
					"be-fr" => "Belgium (fr)",
					"be-nl" => "Belgium (nl)",
					"br-pt" => "Brazil",
					"bg-bg" => "Bulgaria",
					"ca-en" => "Canada (en)",
					"ca-fr" => "Canada (fr)",
					"ct-ca" => "Catalonia",
					"cl-es" => "Chile",
					"cn-zh" => "China",
					"co-es" => "Colombia",
					"hr-hr" => "Croatia",
					"cz-cs" => "Czech Republic",
					"dk-da" => "Denmark",
					"ee-et" => "Estonia",
					"fi-fi" => "Finland",
					"fr-fr" => "France",
					"de-de" => "Germany",
					"gr-el" => "Greece",
					"hk-tzh" => "Hong Kong",
					"hu-hu" => "Hungary",
					"in-en" => "India (en)",
					"id-en" => "Indonesia (en)",
					"ie-en" => "Ireland",
					"il-en" => "Israel (en)",
					"it-it" => "Italy",
					"jp-jp" => "Japan",
					"kr-kr" => "Korea",
					"lv-lv" => "Latvia",
					"lt-lt" => "Lithuania",
					"my-en" => "Malaysia (en)",
					"mx-es" => "Mexico",
					"nl-nl" => "Netherlands",
					"nz-en" => "New Zealand",
					"no-no" => "Norway",
					"pk-en" => "Pakistan (en)",
					"pe-es" => "Peru",
					"ph-en" => "Philippines (en)",
					"pl-pl" => "Poland",
					"pt-pt" => "Portugal",
					"ro-ro" => "Romania",
					"ru-ru" => "Russia",
					"xa-ar" => "Saudi Arabia",
					"sg-en" => "Singapore",
					"sk-sk" => "Slovakia",
					"sl-sl" => "Slovenia",
					"za-en" => "South Africa",
					"es-ca" => "Spain (ca)",
					"es-es" => "Spain (es)",
					"se-sv" => "Sweden",
					"ch-de" => "Switzerland (de)",
					"ch-fr" => "Switzerland (fr)",
					"tw-tzh" => "Taiwan",
					"th-en" => "Thailand (en)",
					"tr-tr" => "Turkey",
					"us-es" => "US (Spanish)",
					"ua-uk" => "Ukraine",
					"uk-en" => "United Kingdom",
					"vn-en" => "Vietnam (en)"
				]
			]
		];
		
		switch($pagetype){
			
			case "web":
				$base["country"]["option"] =
					array_merge(["any" => "All Regions"], $base["country"]["option"]);
				
				return array_merge($base,
					[
						"nsfw" => [
							"display" => "NSFW",
							"option" => [
								"yes" => "Yes",
								"maybe" => "Maybe",
								"no" => "No"
							]
						],
						"newer" => [
							"display" => "Newer than",
							"option" => "_DATE"
						],
						"older" => [
							"display" => "Older than",
							"option" => "_DATE"
						],
						"extendedsearch" => [
							// undefined display
							"option" => [
								"yes" => "Yes",
								"no" => "No",
							]
						]
					]
				);
				break;
			
			case "images":
				return array_merge($base,
					[
						"nsfw" => [
							"display" => "NSFW",
							"option" => [
								"yes" => "Yes",
								"no" => "No"
							]
						],
						"date" => [
							"display" => "Time posted",
							"option" => [
								"any" => "Any time",
								"Day" => "Past day",
								"Week" => "Past week",
								"Month" => "Past month"
							]
						],
						"size" => [
							"display" => "Size",
							"option" => [
								"any" => "Any size",
								"Small" => "Small",
								"Medium" => "Medium",
								"Large" => "Large",
								"Wallpaper" => "Wallpaper"
							]
						],
						"color" => [
							"display" => "Colors",
							"option" => [
								"any" => "All colors",
								"Monochrome" => "Black and white",
								"Red" => "Red",
								"Orange" => "Orange",
								"Yellow" => "Yellow",
								"Green" => "Green",
								"Blue" => "Blue",
								"Purple" => "Purple",
								"Pink" => "Pink",
								"Brown" => "Brown",
								"Black" => "Black",
								"Gray" => "Gray",
								"Teal" => "Teal",
								"White" => "White"
							]
						],
						"type" => [
							"display" => "Type",
							"option" => [
								"any" => "All types",
								"photo" => "Photograph",
								"clipart" => "Clipart",
								"gif" => "Animated GIF",
								"transparent" => "Transparent"
							]
						],
						"layout" => [
							"display" => "Layout",
							"option" => [
								"any" => "All layouts",
								"Square" => "Square",
								"Tall" => "Tall",
								"Wide" => "Wide"
							]
						],
						"license" => [
							"display" => "License",
							"option" => [
								"any" => "All licenses",
								"Any" => "All Creative Commons",
								"Public" => "Public domain",
								"Share" => "Free to Share and Use",
								"ShareCommercially" => "Free to Share and Use Commercially",
								"Modify" => "Free to Modify, Share, and Use",
								"ModifyCommercially" => "Free to Modify, Share, and Use Commercially"
							]
						]
					]
				);
				break;
			
			case "videos":
				return array_merge($base,
					[
						"nsfw" => [
							"display" => "NSFW",
							"option" => [
								"yes" => "Yes",
								"maybe" => "Maybe",
								"no" => "No"
							]
						],
						"date" => [
							"display" => "Time fetched",
							"option" => [
								"any" => "Any time",
								"d" => "Past day",
								"w" => "Past week",
								"m" => "Past month"
							]
						],
						"resolution" => [ //videoDefinition
							"display" => "Resolution",
							"option" => [
								"any" => "Any resolution",
								"high" => "High definition",
								"standard" => "Standard definition"
							]
						],
						"duration" => [ // videoDuration
							"display" => "Duration",
							"option" => [
								"any" => "Any duration",
								"short" => "Short (>5min)",
								"medium" => "Medium (5-20min)",
								"long" => "Long (<20min)"
							]
						],
						"license" => [
							"display" => "License",
							"option" => [
								"any" => "Any license",
								"creativeCommon" => "Creative Commons",
								"youtube" => "YouTube Standard"
							]
						]
					]
				);
				break;
				
			case "news":
				return array_merge($base,
					[
						"nsfw" => [
							"display" => "NSFW",
							"option" => [
								"yes" => "Yes",
								"maybe" => "Maybe",
								"no" => "No"
							]
						],
						"date" => [
							"display" => "Time posted",
							"option" => [
								"any" => "Any time",
								"d" => "Past day",
								"w" => "Past week",
								"m" => "Past month"
							]
						]
					]
				);
				break;
		}
	}
	
	public function web($get){
		
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
		
		if($get["npt"]){
			
			[$js_link, $proxy] = $this->backend->get($get["npt"], "web");
			$js_link = "https://links.duckduckgo.com" . $js_link;
			
			$html = "";
			$get["extendedsearch"] = "no";
			
		}else{
			if(strlen($get["s"]) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			
			// generate filters
			$get_filters = [
				"q" => $get["s"]
			];
			
			if($get["country"] == "any"){
				
				$get_filters["kl"] = "wt-wt";
			}else{
				
				$get_filters["kl"] = $get["country"];
			}
			
			switch($get["nsfw"]){
				
				case "yes": $get_filters["kp"] = "-2"; break;
				case "maybe": $get_filters["kp"] = "-1"; break;
				case "no": $get_filters["kp"] = "1"; break;
			}
			
			$df = true;
			
			if($get["newer"] === false){
				
				if($get["older"] !== false){
					
					$start = 36000;
					$end = $get["older"];
				}else{
					
					$df = false;
				}
			}else{
				
				$start = $get["newer"];
				
				if($get["older"] !== false){
					
					$end = $get["older"];
				}else{
					
					$end = time();
				}
			}
			
			if($df === true){
				$get_filters["df"] = date("Y-m-d", $start) . ".." . date("Y-m-d", $end);
			}
			
			//
			// Get HTML
			//
			try{
				$html = $this->get(
					$proxy,
					"https://duckduckgo.com/",
					$get_filters
				);
			}catch(Exception $e){
				
				throw new Exception("Failed to fetch search page");
			}
			
			$this->fuckhtml->load($html);
			
			$script =
				$this->fuckhtml
				->getElementById(
					"deep_preload_link",
					"link"
				);
			
			if(
				$script === null ||
				!isset($script["attributes"]["href"])
			){
				
				throw new Exception("Failed to grep d.js");
			}
			
			$js_link =
				$this->fuckhtml
				->getTextContent(
					$script["attributes"]["href"]
				);
		}
		
		//
		// Get d.js
		//
		try{
			$js = $this->get(
				$proxy,
				$js_link,
				[],
				ddg::req_xhr
			);
			
		}catch(Exception $e){
			
			throw new Exception("Failed to fetch d.js");
		}
		
		//echo htmlspecialchars($js);
		
		$js_tmp =
			preg_split(
				'/DDG\.pageLayout\.load\(\s*\'d\'\s*,\s*/',
				$js,
				2
			);
		
		if(count($js_tmp) <= 1){
			
			throw new Exception("Failed to grep pageLayout(d)");
		}
		
		$json =
			json_decode(
				$this->fuckhtml
				->extract_json(
					$js_tmp[1]
				),
				true
			);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		//
		// Get search results + NPT token
		//
		foreach($json as $item){
			
			if(isset($item["c"])){
				
				if(
					!isset($item["s"]) &&
					isset($item["t"]) &&
					$item["t"] == "DEEP_ERROR_NO_RESULTS"
				){
					
					return $out;
				}
				
				$table = [];
				
				// get youtube video information
				if(isset($item["video"]["thumbnail_url_template"])){
					
					$thumb =
						[
							"ratio" => "16:9",
							"url" => $this->bingimg($item["video"]["thumbnail_url_template"])
						];
				}else{
					
					$thumb =
						[
							"ratio" => null,
							"url" => null
						];
				}
				
				// get table items
				if(isset($item["rf"])){
					
					foreach($item["rf"] as $hint){
						
						if(
							!isset($hint["label"]["text"]) ||
							!isset($hint["items"][0]["text"])
						){
							
							continue;
						}
						
						$text = [];
						
						foreach($hint["items"] as $text_part){
							
							$text[] = $text_part["text"];
						}
						
						$text = implode(", ", $text);
						
						if(is_numeric($text)){
							
							$text = number_format((string)$text);
						}
						
						$table[$hint["label"]["text"]] = $text;
					}
				}
				
				// get ratings
				if(isset($item["ar"])){
					
					foreach($item["ar"] as $rating){
						
						if(
							isset($rating["aggregateRating"]["bestRating"]) &&
							isset($rating["aggregateRating"]["ratingValue"])
						){
							
							$text = $rating["aggregateRating"]["ratingValue"] . "/" . $rating["aggregateRating"]["bestRating"];
							
							if(isset($rating["aggregateRating"]["reviewCount"])){
								
								$text .= " (" . number_format($rating["aggregateRating"]["reviewCount"]) . " votes)";
							}
							
							$table["Rating"] = $text;
						}
					}
				}
				
				// get sublinks
				$sublinks = [];
				
				if(isset($item["l"])){
					
					foreach($item["l"] as $sublink){
						
						$sublinks[] = [
							"title" => $this->titledots($sublink["text"]),
							"description" => $this->titledots($sublink["snippet"]),
							"url" => $sublink["targetUrl"],
							"date" => null
						];
					}
				}
				
				$title =
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$item["t"]
						)
					);
				
				if(
					$title == "EOF" &&
					strpos(
						$item["c"],
						"google"
					)
				){
					
					continue;
				}
				
				// parse search result
				$out["web"][] = [
					"title" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$item["t"]
							)
						),
					"description" =>
						isset($item["a"]) ?
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$item["a"]
							)
						) : null,
					"url" => $this->unshiturl($item["c"]),
					"date" =>
						isset($item["e"]) ?
						strtotime($item["e"]) : null,
					"type" => "web",
					"thumb" => $thumb,
					"sublink" => $sublinks,
					"table" => $table
				];
				continue;
			}
			
			if(isset($item["n"])){
				
				// get NPT
				$out["npt"] =
					$this->backend->store(
						$item["n"],
						"web",
						$proxy
					);
				continue;
			}
		}
		
		//
		// Get spelling
		//
		$js_tmp =
			preg_split(
				'/DDG\.page\.showMessage\(\s*\'spelling\'\s*,\s*/',
				$js,
				2
			);
		
		if(count($js_tmp) > 1){
			
			$json =
				json_decode(
					$this->fuckhtml
					->extract_json(
						$js_tmp[1]
					),
					true
				);
			
			if($json !== null){
				
				// parse spelling
				// qc=2: including
				
				switch((int)$json["qc"]){
					
					case 2:
						$type = "including";
						break;
					
					default:
						$type = "not_many";
						break;
				}
				
				$out["spelling"] = [
					"type" => $type,
					"using" =>
						$this->fuckhtml
						->getTextContent(
							$json["suggestion"]
						),
					"correction" => html_entity_decode($json["recourseText"])
				];
			}
		}
		
		//
		// Get images
		//
		$js_tmp =
			preg_split(
				'/DDG\.duckbar\.load\(\s*\'images\'\s*,\s*/',
				$js,
				2
			);
		
		if(count($js_tmp) > 1){
			
			$json =
				json_decode(
					$this->fuckhtml
					->extract_json(
						$js_tmp[1]
					),
					true
				);
			
			if($json !== null){
				
				foreach($json["results"] as $image){
					
					$ratio = $this->bingratio((int)$image["width"], (int)$image["height"]);
					
					$out["image"][] = [
						"title" => $image["title"],
						"source" =>	[
							[
								"url" => $image["image"],
								"width" => (int)$image["width"],
								"height" => (int)$image["height"]
							],
							[
								"url" => $this->bingimg($image["thumbnail"]),
								"width" => $ratio[0],
								"height" => $ratio[1]
							]
						],
						"url" => $this->unshiturl($image["url"])
					];
				}
			}
		}
		
		//
		// Get videos
		//
		$js_tmp =
			preg_split(
				'/DDG\.duckbar\.load\(\s*\'videos\'\s*,\s*/',
				$js,
				2
			);
		
		if(count($js_tmp) > 1){
			
			$json =
				json_decode(
					$this->fuckhtml
					->extract_json(
						$js_tmp[1]
					),
					true
				);
			
			if($json !== null){
				
				foreach($json["results"] as $video){
					
					$thumb = [
						"ratio" => null,
						"url" => null
					];
					
					foreach(["large", "medium", "small"] as $contender){
						
						if(isset($video["images"][$contender])){
							
							$thumb = [
								"ratio" => "16:9",
								"url" => $this->bingimg($video["images"][$contender])
							];
							break;
						}
					}
					
					$out["video"][] = [
						"title" => $this->titledots($video["title"]),
						"description" =>
							$video["description"] != "" ?
							$this->titledots($video["description"]) : null,
						"date" => 
							isset($video["published"]) ?
							strtotime($video["published"]) : null,
						"duration" =>
							$video["duration"] != "" ?
							$this->hms2int($video["duration"]) : null,
						"views" =>
							isset($video["statistics"]["viewCount"]) ?
							(int)$video["statistics"]["viewCount"] : null,
						"thumb" => $thumb,
						"url" => $this->unshiturl($video["content"])
					];
				}
			}
		}
		
		//
		// Get news
		//
		$js_tmp =
			preg_split(
				'/DDG\.duckbar\.load\(\s*\'news\'\s*,\s*/',
				$js,
				2
			);
		
		if(count($js_tmp) > 1){
			
			$json =
				json_decode(
					$this->fuckhtml
					->extract_json(
						$js_tmp[1]
					),
					true
				);
			
			if($json !== null){
				
				foreach($json["results"] as $news){
					
					if(isset($news["image"])){
						
						$thumb = [
							"ratio" => "16:9",
							"url" => $news["image"]
						];
					}else{
						
						$thumb = [
							"ratio" => null,
							"url" => null
						];
					}
					
					$out["news"][] = [
						"title" => $news["title"],
						"description" =>
							$this->fuckhtml
							->getTextContent(
								$news["excerpt"]
							),
						"date" => (int)$news["date"],
						"thumb" => $thumb,
						"url" => $news["url"]
					];
				}
			}
		}
		
		//
		// Get related searches
		//
		$js_tmp =
			preg_split(
				'/DDG\.duckbar\.loadModule\(\s*\'related_searches\'\s*,\s*/',
				$js,
				2
			);
		
		if(count($js_tmp) > 1){
			
			$json =
				json_decode(
					$this->fuckhtml
					->extract_json(
						$js_tmp[1]
					),
					true
				);
			
			if($json !== null){
				
				foreach($json["results"] as $related){
					
					$out["related"][] = $related["text"];
				}
			}
		}
		
		//
		// Get instant answers
		//
		$js_tmp =
			preg_split(
				'/DDG\.duckbar\.add\(\s*/',
				$html . $js,
				2
			);
		
		if(count($js_tmp) > 1){
			
			$json =
				json_decode(
					$this->fuckhtml
					->extract_json(
						$js_tmp[1]
					),
					true
				);
			
			if($json !== null){
				
				$json = $json["data"];
				$table = [];
				$sublinks = [];
				$description = [];
				
				// get official website
				if(
					isset($json["OfficialWebsite"]) &&
					$json["OfficialWebsite"] !== null
				){
					
					$sublinks["Website"] = $json["OfficialWebsite"];
				}
				
				// get sublinks & table elements
				if(isset($json["Infobox"]["content"])){
					foreach($json["Infobox"]["content"] as $info){
						
						if($info["data_type"] == "string"){
							
							// add table element
							$table[$info["label"]] = $info["value"];
							continue;
						}
						
						if($info["data_type"] == "wd_description"){
							
							$description[] = [
								"type" => "quote",
								"value" => $info["value"]
							];
							continue;
						}
						
						// add sublink
						switch($info["data_type"]){
							
							case "official_site":
							case "official_website":
								$type = "Website";
								break;
							
							case "wikipedia": $type = "Wikipedia"; break;
							case "itunes": $type = "iTunes"; break;
							case "amazon": $type = "Amazon"; break;
							
							case "imdb_title_id":
							case "imdb_id":
							case "imdb_name_id":
								$type = "IMDb";
								$delim = substr($info["value"], 0, 2);
								
								if($delim == "nm"){
									
									$prefix = "https://www.imdb.com/name/";
								}elseif($delim == "tt"){
									
									$prefix = "https://www.imdb.com/title/";
								}elseif($delim == "co"){
									
									$prefix = "https://www.imdb.com/search/title/?companies=";
								}else{
									
									$prefix = "https://www.imdb.com/title/";
								}
								break;

							case "imdb_name_id": $prefix = "https://www.imdb.com/name/"; $type = "IMDb"; break;
							case "twitter_profile": $prefix = "https://twitter.com/"; $type = "Twitter"; break;
							case "instagram_profile": $prefix = "https://instagram.com/"; $type = "Instagram"; break;
							case "facebook_profile": $prefix = "https://facebook.com/"; $type = "Facebook"; break;
							case "spotify_artist_id": $prefix = "https://open.spotify.com/artist/"; $type = "Spotify"; break;
							case "itunes_artist_id": $prefix = "https://music.apple.com/us/artist/"; $type = "iTunes"; break;
							case "rotten_tomatoes": $prefix = "https://rottentomatoes.com/"; $type = "Rotten Tomatoes"; break;
							case "youtube_channel": $prefix = "https://youtube.com/channel/"; $type = "YouTube"; break;
							case "soundcloud_id": $prefix = "https://soundcloud.com/"; $type = "SoundCloud"; break;
							
							default:							
								$prefix = null;
								$type = false;
						}
						
						if($type !== false){
							
							if($prefix === null){
								
								$sublinks[$type] = $info["value"];
							}else{
								
								$sublinks[$type] = $prefix . $info["value"];
							}
						}
					}
				}
				
				if(isset($json["Abstract"])){
					
					$description[] =
						[
							"type" => "text",
							"value" => $json["Abstract"]
						];
				}
				
				$out["answer"][] = [
					"title" => $json["Heading"],
					"description" => $description,
					"url" => $json["AbstractURL"],
					"thumb" =>
						(!isset($json["Image"]) || $json["Image"] == "" || $json["Image"] === null) ?
						null : "https://duckduckgo.com" . $json["Image"],
					"table" => $table,
					"sublink" => $sublinks
				];
			}
		}
		
		if($get["extendedsearch"] == "no"){
			
			return $out;
		}
		
		//
		// Parse additional data endpoints
		//
		//nrj('/js/spice/dictionary/definition/create', null, null, null, null, 'dictionary_definition');
		
		preg_match_all(
			'/nrj\(\s*\'([^\']+)\'/',
			$js,
			$nrj
		);
		
		if(isset($nrj[1])){
			
			foreach($nrj[1] as $potential_endpoint){
				
				//
				// Probe for wordnik definition
				//
				preg_match(
					'/\/js\/spice\/dictionary\/definition\/([^\/]+)/',
					$potential_endpoint,
					$word
				);
				
				if(isset($word[1])){
					
					$word = $word[1];
					
					// found wordnik definition & word
					try{
						$nik =
							$this->get(
								$proxy,
								"https://duckduckgo.com/js/spice/dictionary/definition/" . $word,
								[],
								ddg::req_xhr
							);
						
					}catch(Exception $e){
						
						// fail gracefully
						return $out;
					}
					
					// remove javascript
					$js_tmp =
						preg_split(
							'/ddg_spice_dictionary_definition\(\s*/',
							$nik,
							2
						);
					
					if(count($js_tmp) > 1){
						
						$nik =
							json_decode(
								$this->fuckhtml
								->extract_json(
									$js_tmp[1]
								),
								true
							);
					}
					
					if($nik === null){
						
						return $out;
					}
					
					$answer_cat = [];
					$answer = [];
					
					foreach($nik as $snippet){
						
						if(!isset($snippet["partOfSpeech"])){ continue; }
						
						$push = [];
						
						// add text snippet
						if(isset($snippet["text"])){
							
							$push[] = [
								"type" => "text",
								"value" =>
									$this->fuckhtml
									->getTextContent(
										$snippet["text"]
									)
							];
						}
						
						// add example uses
						if(isset($snippet["exampleUses"])){
							
							foreach($snippet["exampleUses"] as $example){
								
								$push[] = [
									"type" => "quote",
									"value" => "\"" .
										$this->fuckhtml
										->getTextContent(
											$example["text"]
										) . "\""
								];
							}
						}
						
						// add citations
						if(isset($snippet["citations"])){
							
							foreach($snippet["citations"] as $citation){
								
								if(!isset($citation["cite"])){ continue; }
								
								$text =
									$this->fuckhtml
									->getTextContent(
										$citation["cite"]
									);
								
								if(isset($citation["source"])){
									
									$text .=
										" - " .
										$this->fuckhtml
										->getTextContent(
											$citation["source"]
										);
								}
								
								$push[] = [
									"type" => "quote",
									"value" => $text
								];
							}
						}
						
						// add related words
						if(isset($snippet["relatedWords"])){
							
							$relations = [];
							
							foreach($snippet["relatedWords"] as $related){
								
								$words = [];
								foreach($related["words"] as $wrd){
									
									$words[] =
										$this->fuckhtml
										->getTextContent(
											$wrd
										);
								}
								
								if(
									count($words) !== 0 &&
									isset($related["relationshipType"])
								){
									
									$relations[ucfirst($related["relationshipType"]) . "s"] =
										implode(", ", $words);
								}
							}
							
							foreach($relations as $relation_title => $relation_content){
								
								$push[] = [
									"type" => "quote",
									"value" => $relation_title . ": " . $relation_content
								];
							}
						}
						
						
						if(count($push) !== 0){
							
							// push data to answer_cat
							if(!isset($answer_cat[$snippet["partOfSpeech"]])){
								
								$answer_cat[$snippet["partOfSpeech"]] = [];
							}
							
							$answer_cat[$snippet["partOfSpeech"]] =
								array_merge(
									$answer_cat[$snippet["partOfSpeech"]],
									$push
								);
						}
					}
					
					foreach($answer_cat as $answer_title => $answer_content){
						
						$i = 0;
						$answer[] = [
							"type" => "title",
							"value" => $answer_title
						];
						
						$old_type = $answer[count($answer) - 1]["type"];
						
						foreach($answer_content as $ans){
							
							if(
								$ans["type"] == "text" &&
								$old_type == "text"
							){
								
								$i++;
								$c = count($answer) - 1;
								
								// append text to existing textfield
								$answer[$c] = [
									"type" => "text",
									"value" => $answer[$c]["value"] . "\n" . $i . ". " . $ans["value"]
								];
								
							}elseif($ans["type"] == "text"){
								
								$i++;
								$answer[] = [
									"type" => "text",
									"value" => $i . ". " . $ans["value"]
								];
							}else{
								
								// append normally
								$answer[] = $ans;
							}
							
							$old_type = $ans["type"];
						}
					}
					
					// yeah.. sometimes duckduckgo doesnt give us a definition back
					if(count($answer) !== 0){
						
						$out["answer"][] = [
							"title" => ucfirst($word),
							"description" => $answer,
							"url" => "https://www.wordnik.com/words/" . $word,
							"thumb" => null,
							"table" => [],
							"sublink" => []
						];
					}
				}
				
				//
				// Parse stackoverflow answer
				//
				//$json = 'DDG.duckbar.add_array([{"data":[{"Abstract":"<p> If you are interested in finding out whether a variable has been declared regardless of its value, then using the <code>in</code> operator is the safest way to go. Consider this example: </p>\n\n<pre><code>// global scope\nvar theFu; // theFu has been declared, but its value is undefined\ntypeof theFu; // &quot;undefined&quot;\n</code></pre>\n\n<p> But this may not be the intended result for some cases, since the variable or property was declared but just not initialized. Use the <code>in</code> operator for a more robust <b>check</b>. </p>\n\n<pre><code>&quot;theFu&quot; in window; // true\n&quot;theFoo&quot; in window; // false\n</code></pre>\n\n<p> If you are interested in knowing whether the variable hasn\'t been declared or has the value <code>undefined</code>, then use the <code>typeof</code> operator, which is guaranteed to return a string: </p>\n\n<pre><code>if (typeof myVar !== &#x27;undefined&#x27;)\n</code></pre>\n\n<p> Direct comparisons against <code>undefined</code> are troublesome as <code>undefined</code> can be overwritten.  </p>\n\n<pre><code>window.undefined = &quot;foo&quot;;\n&quot;foo&quot; == undefined // true\n</code></pre>\n\n<p> As @CMS pointed out, this has been patched in ECMAScript 5th ed., and <code>undefined</code> is non-writable. </p>\n\n<p> <code>if (window.myVar)</code> will also include these falsy values, so it\'s not very robust: </p>\n\n<pre>\nfalse\n0\n\"\"\nNaN\nnull\nundefined\n</pre>\n\n<p> Thanks to @CMS for pointing out that your third case - <code>if (myVariable)</code> can also throw an error in two cases. The first is when the variable hasn\'t been defined which throws a <code>ReferenceError</code>.  </p>\n\n<pre><code>// abc was never declared.\nif (abc) {\n    // ReferenceError: abc is not defined\n} \n</code></pre>\n\n<p> The other case is when the variable has been defined, but has a getter function which throws an error when invoked. For example, </p>\n\n<pre><code>// or it&#x27;s a property that can throw an error\nObject.defineProperty(window, &quot;myVariable&quot;, { \n    get: function() { throw new Error(&quot;W00t?&quot;); }, \n    set: undefined \n});\nif (myVariable) {\n    // Error: W00t?\n}\n</code></pre>\n <p>--<a href=\"http://stackoverflow.com/users/165737/ddg\">Anurag</a></p>","AbstractSource":"Stack Overflow","AbstractURL":"http://stackoverflow.com/questions/3390396/ddg#3390426","Heading":"How can I check for undefined in JavaScript","data":[{"accepted":1,"creation_date":"2010-08-02T17:58:18.717","parent_score":3053,"post_links":{"10098816":1,"14572415":1,"1485840":3,"15722425":2,"16142957":1,"17082855":2,"17101585":1,"17297203":1,"18475309":1,"1984721":2,"20502070":1,"20529817":1,"20680223":1,"20824716":1,"20869585":1,"20891039":2,"21188382":2,"21805507":2,"21871775":1,"22481003":2,"22992780":1,"23303729":1,"23481605":1,"24640628":1,"24978423":1,"25093101":1,"26120577":1,"2631001":1,"26487804":1,"26816006":1,"27509":3,"2778901":1,"28535341":1,"29235071":1,"29274374":1,"2985771":3,"30212179":1,"32295428":1,"36038043":1,"37297791":2,"37980559":1,"37981604":1,"38825185":1,"3985661":1,"42025958":1,"42326845":1,"44039387":2,"44309845":1,"44451111":1,"45623767":1,"46349615":1,"46670713":1,"47061118":1,"47765100":1,"48791268":1,"49743198":1,"50672434":1,"51109296":1,"51844419":2,"52102855":1,"53087022":1,"53294206":1,"53309649":1,"55790409":2,"55851196":1,"57923236":2,"5879319":1,"59069809":1,"59573769":1,"59605060":2,"60498918":1,"60862972":2,"61417067":1,"63456991":1,"68305469":1,"68327992":1,"68941436":1,"71710480":1,"71734417":2,"75102037":2,"858181":1,"8675839":1,"9225436":1,"9817488":1},"tags":["|javascript|undefined|"]}],"meta":{"attribution":null,"blockgroup":null,"created_date":"2016-08-24","description":"Programming answers","designer":null,"dev_date":"2015-04-14","dev_milestone":"live","developer":[{"name":"zachthompson","type":"github","url":"https://github.com/zachthompson"}],"example_query":"python merge dicts","id":"stack_overflow","idField":"url","is_stackexchange":1,"js_callback_name":"stack_overflow","live_date":"2015-04-14","maintainer":{"github":"ddg"},"name":"Stack Overflow","perl_module":"DDG::Longtail::StackOverflow","producer":"jdorw","production_state":"offline","repo":"longtail","signal_from":"stack_overflow","src_domain":"stackoverflow.com","src_id":null,"src_name":"Stack Overflow","src_url":" ","status":"live","tab":" ","topic":["programming"],"unsafe":0},"signal":"low","title":"How can I check for undefined in JavaScript"}],"duckbar_topic":"qa","from":"nlp_qa","meta":{"attribution":null,"blockgroup":null,"created_date":"2016-08-24","description":"Programming answers","designer":null,"dev_date":"2015-04-14","dev_milestone":"live","developer":[{"name":"zachthompson","type":"github","url":"https://github.com/zachthompson"}],"example_query":"python merge dicts","id":"stack_overflow","idField":"url","is_stackexchange":1,"js_callback_name":"stack_overflow","live_date":"2015-04-14","maintainer":{"github":"ddg"},"name":"Stack Overflow","perl_module":"DDG::Longtail::StackOverflow","producer":"jdorw","production_state":"offline","repo":"longtail","signal_from":"stack_overflow","src_domain":"stackoverflow.com","src_id":null,"src_name":"Stack Overflow","src_url":" ","status":"live","tab":" ","topic":["programming"],"unsafe":0},"signal":"low","templates":{"detail":"nlp_detail","item":"nlp_item","item_detail":"qa_detail","wrap_detail":"base_detail"}}]);DDH.stack_overflow=DDH.stack_overflow||{};DDH.stack_overflow.meta={"attribution":null,"blockgroup":null,"created_date":"2016-08-24","description":"Programming answers","designer":null,"dev_date":"2015-04-14","dev_milestone":"live","developer":[{"name":"zachthompson","type":"github","url":"https://github.com/zachthompson"}],"example_query":"python merge dicts","id":"stack_overflow","idField":"url","is_stackexchange":1,"js_callback_name":"stack_overflow","live_date":"2015-04-14","maintainer":{"github":"ddg"},"name":"Stack Overflow","perl_module":"DDG::Longtail::StackOverflow","producer":"jdorw","production_state":"offline","repo":"longtail","signal_from":"stack_overflow","src_domain":"stackoverflow.com","src_id":null,"src_name":"Stack Overflow","src_url":" ","status":"live","tab":" ","topic":["programming"],"unsafe":0};';
				//$json = 'DDG.duckbar.add_array([{"data":[{"Abstract":"<p> You can use the <code>convert</code> <b>command</b>: </p>\n<pre>\nconvert input.jpg -rotate <i>&lt;angle in degrees&gt;</i> out.jpg\n</pre>\n<p> To <b>rotate</b> 90 degrees clockwise: </p>\n<pre><code>convert input.jpg -rotate 90 out.jpg\n</code></pre>\n<p> To save the file with the same name: </p>\n<pre><code>convert file.jpg -rotate 90 file.jpg\n</code></pre>\n<p> To <b>rotate</b> all files: </p>\n<pre><code>for photo in *.jpg ; do convert $photo -rotate 90 $photo ; done\n</code></pre>\n<hr />\n<p> Alternatively, you can also use the <a href=\"https://imagemagick.org/script/mogrify.php\" rel=\"noreferrer\"><code>mogrify</code></a> <b>command</b> <b>line</b> tools (<b>the</b> best tool) recommended by <a href=\"https://unix.stackexchange.com/users/22142/don-crissti\">@don-crissti</a><b>:</b> </p>\n<pre><code>mogrify -rotate 90 *.jpg\n</code></pre>\n <p>--<a href=\"http://unix.stackexchange.com/users/153195/ddg\">GAD3R</a><b></p></b>","AbstractSource":"Unix & Linux Stack Exchange","AbstractURL":"http://unix.stackexchange.com/questions/365592/ddg#365595","Heading":"How to rotate a set of pictures from the command line","data":[{"accepted":1,"creation_date":"2017-05-17T11:39:04.000","parent_score":62,"post_links":{"395845":2},"tags":["|command-line|imagemagick|gimp|"]}],"meta":{"attribution":null,"blockgroup":null,"created_date":null,"description":"Question and answer site for users of Linux, FreeBSD and other Un*x-like operating systems","designer":null,"dev_date":"2015-04-14","dev_milestone":"live","developer":[{"name":"DDG Team","type":"ddg","url":"http://www.duckduckhack.com"}],"example_query":"use DD to migrate data from an old drive to a new drive","id":"unix","idField":"url","is_stackexchange":1,"js_callback_name":"unix","live_date":"2015-04-14","maintainer":{"github":"duckduckgo"},"name":"Unix & Linux Stack Exchange","perl_module":"DDG::Longtail::Unix","producer":null,"production_state":"offline","repo":"longtail","signal_from":"unix","src_domain":"unix.stackexchange.com","src_id":null,"src_name":"Unix StackExchange","src_url":"unix.stackexchange.com","status":"live","tab":null,"topic":["sysadmin"],"unsafe":0},"signal":"low","title":"How to rotate a set of pictures from the command line"}],"duckbar_topic":"qa","from":"nlp_qa","meta":{"attribution":null,"blockgroup":null,"created_date":null,"description":"Question and answer site for users of Linux, FreeBSD and other Un*x-like operating systems","designer":null,"dev_date":"2015-04-14","dev_milestone":"live","developer":[{"name":"DDG Team","type":"ddg","url":"http://www.duckduckhack.com"}],"example_query":"use DD to migrate data from an old drive to a new drive","id":"unix","idField":"url","is_stackexchange":1,"js_callback_name":"unix","live_date":"2015-04-14","maintainer":{"github":"duckduckgo"},"name":"Unix & Linux Stack Exchange","perl_module":"DDG::Longtail::Unix","producer":null,"production_state":"offline","repo":"longtail","signal_from":"unix","src_domain":"unix.stackexchange.com","src_id":null,"src_name":"Unix StackExchange","src_url":"unix.stackexchange.com","status":"live","tab":null,"topic":["sysadmin"],"unsafe":0},"signal":"low","templates":{"detail":"nlp_detail","item":"nlp_item","item_detail":"qa_detail","wrap_detail":"base_detail"}}]);DDH.unix=DDH.unix||{};DDH.unix.meta={"attribution":null,"blockgroup":null,"created_date":null,"description":"Question and answer site for users of Linux, FreeBSD and other Un*x-like operating systems","designer":null,"dev_date":"2015-04-14","dev_milestone":"live","developer":[{"name":"DDG Team","type":"ddg","url":"http://www.duckduckhack.com"}],"example_query":"use DD to migrate data from an old drive to a new drive","id":"unix","idField":"url","is_stackexchange":1,"js_callback_name":"unix","live_date":"2015-04-14","maintainer":{"github":"duckduckgo"},"name":"Unix & Linux Stack Exchange","perl_module":"DDG::Longtail::Unix","producer":null,"production_state":"offline","repo":"longtail","signal_from":"unix","src_domain":"unix.stackexchange.com","src_id":null,"src_name":"Unix StackExchange","src_url":"unix.stackexchange.com","status":"live","tab":null,"topic":["sysadmin"],"unsafe":0};';
				
				if(
					preg_match(
						'/^\/a\.js.*src_id=stack_overflow/',
						$potential_endpoint
					)
				){
					
					// found stackoverflow answer
					try{
						$json =
							$this->get(
								$proxy,
								"https://duckduckgo.com" . $potential_endpoint,
								[],
								ddg::req_xhr
							);
						
					}catch(Exception $e){
						
						// fail gracefully
						return $out;
					}
					
					$json = explode("DDG.duckbar.add_array(", $json, 2);
					
					if(count($json) === 2){
						
						$json =
							json_decode(
								$this->fuckhtml
								->extract_json(
									$json[1]
								),
								true
							);
						
						if(
							$json !== null &&
							isset($json[0]["data"])
						){
							
							$json = $json[0]["data"];
							
							foreach($json as $answer){
								
								if(isset($answer["Heading"])){
									
									$title = $answer["Heading"];
								}elseif(isset($answer["title"])){
									
									$title = $answer["title"];
								}else{
									
									$title = null;
								}
								
								if(
									$title !== null &&
									isset($answer["Abstract"])
								){
									
									// got some data
									$description = [];
									$html = &$answer["Abstract"];
									
									// pre-process the html, remove useless elements
									$html =
										strip_tags(
											$html,
											[
												"h1", "h2", "h3", "h4", "h5", "h6", "h7",
												"pre", "code"
											]
										);
									
									$html =
										preg_replace(
											'/<(\/?)pre *[^>]*>\s*<\/?code *[^>]*>/i',
											'<$1pre>',
											$html
										);
									
									$this->fuckhtml->load($html);
									
									$tags =
										$this->fuckhtml
										->getElementsByTagName(
											"*"
										);
									
									if(count($tags) === 0){
										
										$description = [
											"type" => "text",
											"value" =>
												trim(
													$this->fuckhtml
													->getTextContent(
														substr(
															$html,
															$start,
															$tag["startPos"] - $start
														),
														true,
														false
													)
												)
										];
									}else{
										
										$start = 0;
										$was_code_block = true;
										foreach($tags as $tag){
											
											$text =
												$this->fuckhtml
												->getTextContent(
													substr(
														$html,
														$start,
														$tag["startPos"] - $start
													),
													true,
													false
												);
											
											if($was_code_block){
												
												$text = ltrim($text);
												$was_code_block = false;
											}
											
											$description[] = [
												"type" => "text",
												"value" => $text
											];
											
											switch($tag["tagName"]){
												
												case "pre":
													$append = "code";
													$was_code_block = true;
													$c = count($description) - 1;
													$description[$c]["value"] =
														rtrim($description[$c]["value"]);
													break;
												
												case "code":
													$append = "inline_code";
													$c = count($description) - 1;
													$description[$c]["value"] =
														rtrim($description[$c]["value"]) . " ";
													break;
												
												case "h1":
												case "h2":
												case "h3":
												case "h4":
												case "h5":
												case "h6":
												case "h7":
													$append = "title";
													$c = count($description) - 1;
													$description[$c]["value"] =
														rtrim($description[$c]["value"]);
													break;
											}
											
											$description[] = [
												"type" => $append,
												"value" =>
													trim(
														$this->fuckhtml
														->getTextContent(
															$tag,
															true,
															false
														)
													)
											];
											
											$start = $tag["endPos"];
										}
										
										// shit out remainder
										$description[] = [
											"type" => "text",
											"value" =>
												trim(
													$this->fuckhtml
													->getTextContent(
														substr(
															$html,
															$start
														),
														true,
														false
													)
												)
										];
									}
									
									$out["answer"][] = [
										"title" => $title,
										"description" => $description,
										"url" => $answer["AbstractURL"],
										"thumb" => null,
										"table" => [],
										"sublink" => []
									];
								}
							}
						}
					}
				}
			}
		}
		
		return $out;
	}
	
	public function image($get){
		
		if($get["npt"]){
			
			[$js_link, $proxy] = $this->backend->get($get["npt"], "images");
			
		}else{
			if(strlen($get["s"]) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			
			$filters = [];
			
			if($get["date"] != "any"){ $filters[] = "time:{$get["date"]}"; }
			if($get["size"] != "any"){ $filters[] = "size:{$get["size"]}"; }
			if($get["color"] != "any"){ $filters[] = "color:{$get["color"]}"; }
			if($get["type"] != "any"){ $filters[] = "type:{$get["type"]}"; }
			if($get["layout"] != "any"){ $filters[] = "layout:{$get["layout"]}"; }
			if($get["license"] != "any"){ $filters[] = "license:{$get["license"]}"; }
			
			$filters = implode(",", $filters);
			
			$get_filters = [
				"q" => $get["s"],
				"iax" => "images",
				"ia" => "images"
			];
			
			if($filters != ""){
				
				$get_filters["iaf"] = $filters;
			}
			
			$nsfw = $get["nsfw"] == "yes" ? "-1" : "1";
			$get_filters["kp"] = $nsfw;
			
			try{
				
				$html = $this->get(
					$proxy,
					"https://duckduckgo.com",
					$get_filters,
					ddg::req_web
				);
			}catch(Exception $err){
				
				throw new Exception("Failed to fetch search page");
			}
			
			preg_match(
				'/vqd="([0-9-]+)"/',
				$html,
				$vqd
			);
			
			if(!isset($vqd[1])){
				
				throw new Exception("Failed to grep VQD token");
			}
			
			$js_link =
				"i.js?" .
				http_build_query([
					"l" => $get["country"],
					"o" => "json",
					"q" => $get["s"],
					"vqd" => $vqd[1],
					"f" => $filters,
					"p" => $nsfw
				]);
		}
		
		try{
			
			$json =
				$this->get(
					$proxy,
					"https://duckduckgo.com/" . $js_link,
					[],
					ddg::req_xhr
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get i.js");
		}
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		if(!isset($json["results"])){
			
			return $out;
		}
		
		// get npt
		if(
			isset($json["next"]) &&
			$json["next"] !== null
		){
			
			$vqd = null;
			
			if(isset($vqd[1])){
				
				$vqd = $vqd[1];
			}else{
				
				$vqd = array_values($json["vqd"]);
				
				if(count($vqd) > 0){
					
					$vqd = $vqd[0];
				}
			}
			
			if($vqd !== null){
				
				$out["npt"] =
					$this->backend->store(
						$json["next"] . "&vqd=" . $vqd,
						"images",
						$proxy
					);
			}
		}
		
		// get images
		foreach($json["results"] as $image){
			
			$ratio =
				$this->bingratio(
					(int)$image["width"],
					(int)$image["height"]
				);
			
			$out["image"][] = [
				"title" => $this->titledots($image["title"]),
				"source" => [
					[
						"url" => $image["image"],
						"width" => (int)$image["width"],
						"height" => (int)$image["height"]
					],
					[
						"url" => $this->bingimg($image["thumbnail"]),
						"width" => $ratio[0],
						"height" => $ratio[1]
					]
				],
				"url" => $this->unshiturl($image["url"])
			];
		}
		
		return $out;
	}
	
	public function video($get){
		
		if($get["npt"]){
			
			[$js_link, $proxy] = $this->backend->get($get["npt"], "videos");
			
		}else{
			if(strlen($get["s"]) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			
			$get_filters = [
				"q" => $get["s"],
				"iax" => "videos",
				"ia" => "videos"
			];
			
			switch($get["nsfw"]){
				
				case "yes": $nsfw = "-2"; break;
				case "maybe": $nsfw = "-1"; break;
				case "no": $nsfw = "1"; break;
			}
			
			$filters = [];
			
			if($get["date"] != "any"){ $filters[] = "publishedAfter:{$date}"; }
			if($get["resolution"] != "any"){ $filters[] = "videoDefinition:{$resolution}"; }
			if($get["duration"] != "any"){ $filters[] = "videoDuration:{$duration}"; }
			if($get["license"] != "any"){ $filters[] = "videoLicense:{$license}"; }
			
			$filters = implode(",", $filters);
			
			if($filters != ""){
				
				$get_filters["iaf"] = $filters;
			}
			
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://duckduckgo.com/",
						$get_filters,
						ddg::req_web
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
			preg_match(
				'/vqd="([0-9-]+)"/',
				$html,
				$vqd
			);
			
			if(!isset($vqd[1])){
				
				throw new Exception("Failed to grep VQD token");
			}
			
			$js_link =
				"v.js?" .
				http_build_query([
					"l" => $get["country"],
					"o" => "json",
					"sr" => "1",
					"q" => $get["s"],
					"vqd" => $vqd[1],
					"f" => $filters,
					"p" => $nsfw
				]);
		}
		
		try{
			
			$json =
				$this->get(
					$proxy,
					"https://duckduckgo.com/" . $js_link,
					[],
					ddg::req_xhr
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"video" => [],
			"author" => [],
			"livestream" => [],
			"playlist" => [],
			"reel" => []
		];
		
		if(!isset($json["results"])){
			
			return $out;
		}
		
		// get NPT
		if(
			isset($json["next"]) &&
			$json["next"] !== null
		){
			
			$out["npt"] =
				$this->backend->store(
					$json["next"],
					"videos",
					$proxy
				);
		}
		
		foreach($json["results"] as $video){
			
			$thumb = [
				"ratio" => null,
				"url" => null
			];
			
			foreach(["large", "medium", "small"] as $contender){
				
				if(isset($video["images"][$contender])){
					
					$thumb = [
						"ratio" => "16:9",
						"url" => $this->bingimg($video["images"][$contender])
					];
					break;
				}
			}
			
			$out["video"][] = [
				"title" => $this->titledots($video["title"]),
				"description" => $this->titledots($video["description"]),
				"author" => [
					"name" =>
						(
							isset($video["uploader"]) &&
							$video["uploader"] != ""
						) ?
						$video["uploader"] : null,
					"url" => null,
					"avatar" => null
				],
				"date" =>
					(
						isset($video["published"]) &&
						$video["published"] != ""
					) ?
					strtotime($video["published"]) : null,
				"duration" =>
					(
						isset($video["duration"]) &&
						$video["duration"] != ""
					) ?
					$this->hms2int($video["duration"]) : null,
				"views" =>
					isset($video["statistics"]["viewCount"]) ?
					(int)$video["statistics"]["viewCount"] : null,
				"thumb" => $thumb,
				"url" => $this->unshiturl($video["content"])
			];
		}
		
		return $out;
	}
	
	public function news($get){
		
		if($get["npt"]){
			
			[$js_link, $proxy] = $this->backend->get($get["npt"], "news");
			
		}else{
			if(strlen($get["s"]) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			
			$get_filters = [
				"q" => $get["s"],
				"iar" => "news",
				"ia" => "news"
			];
			
			if($get["date"] != "any"){
				
				$date = $get["date"];
				$get_filters["df"] = $date;
			}else{
				
				$date = "";
			}
			
			switch($get["nsfw"]){
				
				case "yes": $get_filters["kp"] = "-2"; break;
				case "maybe": $get_filters["kp"] = "-1"; break;
				case "no": $get_filters["kp"] = "1"; break;
			}
			
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://duckduckgo.com/",
						$get_filters,
						ddg::req_web
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
			preg_match(
				'/vqd="([0-9-]+)"/',
				$html,
				$vqd
			);
			
			if(!isset($vqd[1])){
				
				throw new Exception("Failed to grep VQD token");
			}
			
			$js_link =
				"news.js?" .
				http_build_query([
					"l" => $get["country"],
					"o" => "json",
					"noamp" => "1",
					"m" => "30",
					"q" => $get["s"],
					"vqd" => $vqd[1],
					"p" => $get_filters["kp"],
					"df" => $date,
					"u" => "bing"
				]);
		}
		
		try{
			
			$json =
				$this->get(
					$proxy,
					"https://duckduckgo.com/" . $js_link,
					[],
					ddg::req_xhr
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		if(!isset($json["results"])){
			
			return $out;
		}
		
		// get NPT
		if(
			isset($json["next"]) &&
			$json["next"] !== null
		){
			
			$out["npt"] =
				$this->backend->store(
					$json["next"],
					"news",
					$proxy
				);
		}
		
		foreach($json["results"] as $news){
			
			if(
				isset($news["image"]) &&
				$news["image"] != ""
			){
				
				$thumb = [
					"ratio" => "16:9",
					"url" => $news["image"]
				];
			}else{
				
				$thumb = [
					"ratio" => null,
					"url" => null
				];
			}
			
			$out["news"][] = [
				"title" => $news["title"],
				"author" =>
					(
						isset($news["source"]) &&
						$news["source"] != ""
					) ?
					$news["source"] : null,
				"description" =>
					(
						isset($news["excerpt"]) &&
						$news["excerpt"] != ""
					) ?
					$this->fuckhtml
					->getTextContent(
						$news["excerpt"]
					) : null,
				"date" =>
					isset($news["date"]) ?
					(int)$news["date"] : null,
				"thumb" => $thumb,
				"url" => $this->unshiturl($news["url"])
			];
		}
		
		return $out;
	}
	
	private function titledots($title){
		
		$substr = substr($title, -3);
		
		if(
			$substr == "..." ||
			$substr == "…"
		){
						
			return trim(substr($title, 0, -3));
		}
		
		return trim($title);
	}
	
	private function hms2int($time){
		
		$parts = explode(":", $time, 3);
		$time = 0;
		
		if(count($parts) === 3){
			
			// hours
			$time = $time + ((int)$parts[0] * 3600);
			array_shift($parts);
		}
		
		if(count($parts) === 2){
			
			// minutes
			$time = $time + ((int)$parts[0] * 60);
			array_shift($parts);
		}
		
		// seconds
		$time = $time + (int)$parts[0];
		
		return $time;
	}

	
	private function unshiturl($url){
		
		// check for domains w/out first short subdomain (ex: www.)
		
		$domain = parse_url($url, PHP_URL_HOST);
		
		$subdomain = preg_replace(
			'/^[A-z0-9]{1,3}\./',
			"",
			$domain
		);
		
		switch($subdomain){
			case "ebay.com.au":
			case "ebay.at":
			case "ebay.ca":
			case "ebay.fr":
			case "ebay.de":
			case "ebay.com.hk":
			case "ebay.ie":
			case "ebay.it":
			case "ebay.com.my":
			case "ebay.nl":
			case "ebay.ph":
			case "ebay.pl":
			case "ebay.com.sg":
			case "ebay.es":
			case "ebay.ch":
			case "ebay.co.uk":
			case "cafr.ebay.ca":
			case "ebay.com":
			case "community.ebay.com":
			case "pages.ebay.com":
				
				// remove ebay tracking elements
				$old_params = parse_url($url, PHP_URL_QUERY);
				parse_str($old_params, $params);
				
				if(isset($params["mkevt"])){ unset($params["mkevt"]); }
				if(isset($params["mkcid"])){ unset($params["mkcid"]); }
				if(isset($params["mkrid"])){ unset($params["mkrid"]); }
				if(isset($params["campid"])){ unset($params["campid"]); }
				if(isset($params["customid"])){ unset($params["customid"]); }
				if(isset($params["toolid"])){ unset($params["toolid"]); }
				if(isset($params["_sop"])){ unset($params["_sop"]); }
				if(isset($params["_dcat"])){ unset($params["_dcat"]); }
				if(isset($params["epid"])){ unset($params["epid"]); }
				if(isset($params["epid"])){ unset($params["oid"]); }
				
				$params = http_build_query($params);
				
				if(strlen($params) === 0){
					$replace = "\?";
				}else{
					$replace = "";
				}
				
				$url = preg_replace(
					"/" . $replace . preg_quote($old_params, "/") . "$/",
					$params,
					$url
				);
				break;
		}
		
		return $url;
	}
	
	private function bingimg($url){
		
		$image = parse_url($url);
		
		$id = null;
		if(isset($image["query"])){
			
			parse_str($image["query"], $str);
			
			if(isset($str["id"])){
				
				$id = $str["id"];
			}
		}
		
		if($id === null){
			
			$id = explode("/th/id/", $image["path"], 2);
			
			if(count($id) !== 2){
				
				// malformed
				return $url;
			}
			
			$id = $id[1];
		}
		
		return "https://" . $image["host"] . "/th?id=" . rawurlencode($id);
	}
	
	private function bingratio($width, $height){
		
		$ratio = [
			474 / $width,
			474 / $height
		];
		
		if($ratio[0] < $ratio[1]){
			
			$ratio = $ratio[0];
		}else{
			
			$ratio = $ratio[1];
		}
		
		return [
			floor($width * $ratio),
			floor($height * $ratio)
		];
	}
}
