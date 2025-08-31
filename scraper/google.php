<?php

// @TODO check for consent.google.com page, if need be

class google{
	
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/backend.php";
		$this->backend = new backend("google");
	}
	
	public function getfilters($page){
		
		$base = [
			"country" => [ // gl=<country> (image: cr=countryAF)
				"display" => "Country",
				"option" => [
					"any" => "Instance's country",
					"af" => "Afghanistan",
					"al" => "Albania",
					"dz" => "Algeria",
					"as" => "American Samoa",
					"ad" => "Andorra",
					"ao" => "Angola",
					"ai" => "Anguilla",
					"aq" => "Antarctica",
					"ag" => "Antigua and Barbuda",
					"ar" => "Argentina",
					"am" => "Armenia",
					"aw" => "Aruba",
					"au" => "Australia",
					"at" => "Austria",
					"az" => "Azerbaijan",
					"bs" => "Bahamas",
					"bh" => "Bahrain",
					"bd" => "Bangladesh",
					"bb" => "Barbados",
					"by" => "Belarus",
					"be" => "Belgium",
					"bz" => "Belize",
					"bj" => "Benin",
					"bm" => "Bermuda",
					"bt" => "Bhutan",
					"bo" => "Bolivia",
					"ba" => "Bosnia and Herzegovina",
					"bw" => "Botswana",
					"bv" => "Bouvet Island",
					"br" => "Brazil",
					"io" => "British Indian Ocean Territory",
					"bn" => "Brunei Darussalam",
					"bg" => "Bulgaria",
					"bf" => "Burkina Faso",
					"bi" => "Burundi",
					"kh" => "Cambodia",
					"cm" => "Cameroon",
					"ca" => "Canada",
					"cv" => "Cape Verde",
					"ky" => "Cayman Islands",
					"cf" => "Central African Republic",
					"td" => "Chad",
					"cl" => "Chile",
					"cn" => "China",
					"cx" => "Christmas Island",
					"cc" => "Cocos (Keeling) Islands",
					"co" => "Colombia",
					"km" => "Comoros",
					"cg" => "Congo",
					"cd" => "Congo, the Democratic Republic",
					"ck" => "Cook Islands",
					"cr" => "Costa Rica",
					"ci" => "Cote D'ivoire",
					"hr" => "Croatia",
					"cu" => "Cuba",
					"cy" => "Cyprus",
					"cz" => "Czech Republic",
					"dk" => "Denmark",
					"dj" => "Djibouti",
					"dm" => "Dominica",
					"do" => "Dominican Republic",
					"ec" => "Ecuador",
					"eg" => "Egypt",
					"sv" => "El Salvador",
					"gq" => "Equatorial Guinea",
					"er" => "Eritrea",
					"ee" => "Estonia",
					"et" => "Ethiopia",
					"fk" => "Falkland Islands (Malvinas)",
					"fo" => "Faroe Islands",
					"fj" => "Fiji",
					"fi" => "Finland",
					"fr" => "France",
					"gf" => "French Guiana",
					"pf" => "French Polynesia",
					"tf" => "French Southern Territories",
					"ga" => "Gabon",
					"gm" => "Gambia",
					"ge" => "Georgia",
					"de" => "Germany",
					"gh" => "Ghana",
					"gi" => "Gibraltar",
					"gr" => "Greece",
					"gl" => "Greenland",
					"gd" => "Grenada",
					"gp" => "Guadeloupe",
					"gu" => "Guam",
					"gt" => "Guatemala",
					"gn" => "Guinea",
					"gw" => "Guinea-Bissau",
					"gy" => "Guyana",
					"ht" => "Haiti",
					"hm" => "Heard Island and Mcdonald Islands",
					"va" => "Holy See (Vatican City State)",
					"hn" => "Honduras",
					"hk" => "Hong Kong",
					"hu" => "Hungary",
					"is" => "Iceland",
					"in" => "India",
					"id" => "Indonesia",
					"ir" => "Iran, Islamic Republic",
					"iq" => "Iraq",
					"ie" => "Ireland",
					"il" => "Israel",
					"it" => "Italy",
					"jm" => "Jamaica",
					"jp" => "Japan",
					"jo" => "Jordan",
					"kz" => "Kazakhstan",
					"ke" => "Kenya",
					"ki" => "Kiribati",
					"kp" => "Korea, Democratic People's Republic",
					"kr" => "Korea, Republic",
					"kw" => "Kuwait",
					"kg" => "Kyrgyzstan",
					"la" => "Lao People's Democratic Republic",
					"lv" => "Latvia",
					"lb" => "Lebanon",
					"ls" => "Lesotho",
					"lr" => "Liberia",
					"ly" => "Libyan Arab Jamahiriya",
					"li" => "Liechtenstein",
					"lt" => "Lithuania",
					"lu" => "Luxembourg",
					"mo" => "Macao",
					"mk" => "Macedonia, the Former Yugosalv Republic",
					"mg" => "Madagascar",
					"mw" => "Malawi",
					"my" => "Malaysia",
					"mv" => "Maldives",
					"ml" => "Mali",
					"mt" => "Malta",
					"mh" => "Marshall Islands",
					"mq" => "Martinique",
					"mr" => "Mauritania",
					"mu" => "Mauritius",
					"yt" => "Mayotte",
					"mx" => "Mexico",
					"fm" => "Micronesia, Federated States",
					"md" => "Moldova, Republic",
					"mc" => "Monaco",
					"mn" => "Mongolia",
					"ms" => "Montserrat",
					"ma" => "Morocco",
					"mz" => "Mozambique",
					"mm" => "Myanmar",
					"na" => "Namibia",
					"nr" => "Nauru",
					"np" => "Nepal",
					"nl" => "Netherlands",
					"an" => "Netherlands Antilles",
					"nc" => "New Caledonia",
					"nz" => "New Zealand",
					"ni" => "Nicaragua",
					"ne" => "Niger",
					"ng" => "Nigeria",
					"nu" => "Niue",
					"nf" => "Norfolk Island",
					"mp" => "Northern Mariana Islands",
					"no" => "Norway",
					"om" => "Oman",
					"pk" => "Pakistan",
					"pw" => "Palau",
					"ps" => "Palestinian Territory, Occupied",
					"pa" => "Panama",
					"pg" => "Papua New Guinea",
					"py" => "Paraguay",
					"pe" => "Peru",
					"ph" => "Philippines",
					"pn" => "Pitcairn",
					"pl" => "Poland",
					"pt" => "Portugal",
					"pr" => "Puerto Rico",
					"qa" => "Qatar",
					"re" => "Reunion",
					"ro" => "Romania",
					"ru" => "Russian Federation",
					"rw" => "Rwanda",
					"sh" => "Saint Helena",
					"kn" => "Saint Kitts and Nevis",
					"lc" => "Saint Lucia",
					"pm" => "Saint Pierre and Miquelon",
					"vc" => "Saint Vincent and the Grenadines",
					"ws" => "Samoa",
					"sm" => "San Marino",
					"st" => "Sao Tome and Principe",
					"sa" => "Saudi Arabia",
					"sn" => "Senegal",
					"cs" => "Serbia and Montenegro",
					"sc" => "Seychelles",
					"sl" => "Sierra Leone",
					"sg" => "Singapore",
					"sk" => "Slovakia",
					"si" => "Slovenia",
					"sb" => "Solomon Islands",
					"so" => "Somalia",
					"za" => "South Africa",
					"gs" => "South Georgia and the South Sandwich Islands",
					"es" => "Spain",
					"lk" => "Sri Lanka",
					"sd" => "Sudan",
					"sr" => "Suriname",
					"sj" => "Svalbard and Jan Mayen",
					"sz" => "Swaziland",
					"se" => "Sweden",
					"ch" => "Switzerland",
					"sy" => "Syrian Arab Republic",
					"tw" => "Taiwan, Province of China",
					"tj" => "Tajikistan",
					"tz" => "Tanzania, United Republic",
					"th" => "Thailand",
					"tl" => "Timor-Leste",
					"tg" => "Togo",
					"tk" => "Tokelau",
					"to" => "Tonga",
					"tt" => "Trinidad and Tobago",
					"tn" => "Tunisia",
					"tr" => "Turkey",
					"tm" => "Turkmenistan",
					"tc" => "Turks and Caicos Islands",
					"tv" => "Tuvalu",
					"ug" => "Uganda",
					"ua" => "Ukraine",
					"ae" => "United Arab Emirates",
					"uk" => "United Kingdom",
					"us" => "United States",
					"um" => "United States Minor Outlying Islands",
					"uy" => "Uruguay",
					"uz" => "Uzbekistan",
					"vu" => "Vanuatu",
					"ve" => "Venezuela",
					"vn" => "Viet Nam",
					"vg" => "Virgin Islands, British",
					"vi" => "Virgin Islands, U.S.",
					"wf" => "Wallis and Futuna",
					"eh" => "Western Sahara",
					"ye" => "Yemen",
					"zm" => "Zambia",
					"zw" => "Zimbabwe"
				]
			],
			"nsfw" => [
				"display" => "NSFW",
				"option" => [
					"yes" => "Yes", // safe=active
					"no" => "No" // safe=off
				]
			]
		];
		
		switch($page){
			
			case "web":
				return array_merge(
					$base,
					[
						"lang" => [ // lr=<lang> (prefix lang with "lang_")
							"display" => "Language",
							"option" => [
								"any" => "Any language",
								"ar" => "Arabic",
								"bg" => "Bulgarian",
								"ca" => "Catalan",
								"cs" => "Czech",
								"da" => "Danish",
								"de" => "German",
								"el" => "Greek",
								"en" => "English",
								"es" => "Spanish",
								"et" => "Estonian",
								"fi" => "Finnish",
								"fr" => "French",
								"hr" => "Croatian",
								"hu" => "Hungarian",
								"id" => "Indonesian",
								"is" => "Icelandic",
								"it" => "Italian",
								"iw" => "Hebrew",
								"ja" => "Japanese",
								"ko" => "Korean",
								"lt" => "Lithuanian",
								"lv" => "Latvian",
								"nl" => "Dutch",
								"no" => "Norwegian",
								"pl" => "Polish",
								"pt" => "Portuguese",
								"ro" => "Romanian",
								"ru" => "Russian",
								"sk" => "Slovak",
								"sl" => "Slovenian",
								"sr" => "Serbian",
								"sv" => "Swedish",
								"tr" => "Turkish",
								"zh-CN" => "Chinese (Simplified)",
								"zh-TW" => "Chinese (Traditional)"
							]
						],
						"newer" => [ // tbs
							"display" => "Newer than",
							"option" => "_DATE"
						],
						"older" => [
							"display" => "Older than",
							"option" => "_DATE"
						],
						"spellcheck" => [
							"display" => "Spellcheck",
							"option" => [
								"yes" => "Yes",
								"no" => "No"
							]
						]
					]
				);
				break;
			
			case "images":
				return array_merge(
					$base,
					[
						"time" => [ // tbs=qdr:<time>
							"display" => "Time posted",
							"option" => [
								"any" => "Any time",
								"d" => "Past 24 hours",
								"w" => "Past week",
								"m" => "Past month",
								"y" => "Past year"
							]
						],
						"size" => [ // imgsz
							"display" => "Size",
							"option" => [
								"any" => "Any size",
								"l" => "Large",
								"m" => "Medium",
								"i" => "Icon",
								"qsvga" => "Larger than 400x300",
								"vga" => "Larger than 640x480",
								"svga" => "Larger than 800x600",
								"xga" => "Larger than 1024x768",
								"2mp" => "Larger than 2MP",
								"4mp" => "Larger than 4MP",
								"6mp" => "Larger than 6MP",
								"8mp" => "Larger than 8MP",
								"10mp" => "Larger than 10MP",
								"12mp" => "Larger than 12MP",
								"15mp" => "Larger than 15MP",
								"20mp" => "Larger than 20MP",
								"40mp" => "Larger than 40MP",
								"70mp" => "Larger than 70MP"
							]
						],
						"ratio" => [ // imgar
							"display" => "Aspect ratio",
							"option" => [
								"any" => "Any ratio",
								"t|xt" => "Tall",
								"s" => "Square",
								"w" => "Wide",
								"xw" => "Panoramic"
							]
						],
						"color" => [ // imgc
							"display" => "Color",
							"option" => [
								"any" => "Any color",
								"color" => "Full color",
								"bnw" => "Black & white",
								"trans" => "Transparent",
								// from here, imgcolor
								"red" => "Red",
								"orange" => "Orange",
								"yellow" => "Yellow",
								"green" => "Green",
								"teal" => "Teal",
								"blue" => "Blue",
								"purple" => "Purple",
								"pink" => "Pink",
								"white" => "White",
								"gray" => "Gray",
								"black" => "Black",
								"brown" => "Brown"
							]
						],
						"type" => [ // tbs=itp:<type>
							"display" => "Type",
							"option" => [
								"any" => "Any type",
								"clipart" => "Clip Art",
								"lineart" => "Line Drawing",
								"animated" => "Animated"
							]
						],
						"format" => [ // as_filetype
							"display" => "Format",
							"option" => [
								"any" => "Any format",
								"jpg" => "JPG",
								"gif" => "GIF",
								"png" => "PNG",
								"bmp" => "BMP",
								"svg" => "SVG",
								"webp" => "WEBP",
								"ico" => "ICO",
								"craw" => "RAW"
							]
						],
						"rights" => [ // tbs=sur:<rights>
							"display" => "Usage rights",
							"option" => [
								"any" => "Any license",
								"cl" => "Creative Commons licenses",
								"ol" => "Commercial & other licenses"
							]
						]
					]
				);
				break;
			
			case "videos":
				return array_merge(
					$base,
					[
						"newer" => [ // tbs
							"display" => "Newer than",
							"option" => "_DATE"
						],
						"older" => [
							"display" => "Older than",
							"option" => "_DATE"
						],
						"duration" => [
							"display" => "Duration",
							"option" => [
								"any" => "Any duration",
								"s" => "Short (0-4min)", // tbs=dur:s
								"m" => "Medium (4-20min)", // tbs=dur:m
								"l" => "Long (20+ min)" // tbs=dur:l
							]
						],
						"quality" => [
							"display" => "Quality",
							"option" => [
								"any" => "Any quality",
								"h" => "High quality" // tbs=hq:h
							]
						],
						"captions" => [
							"display" => "Captions",
							"option" => [
								"any" => "No preference",
								"yes" => "Closed captioned" // tbs=cc:1
							]
						]
					]
				);
				break;
			
			case "news":
				return array_merge(
					$base,
					[
						"newer" => [ // tbs
							"display" => "Newer than",
							"option" => "_DATE"
						],
						"older" => [
							"display" => "Older than",
							"option" => "_DATE"
						],
						"sort" => [
							"display" => "Sort",
							"option" => [
								"relevance" => "Relevance", 
								"date" => "Date" // sbd:1
							]
						]
					]
				);
				break;
		}
	}
	
	private function get($proxy, $url, $get = [], $use_lynx = false){
		
		$curlproc = curl_init();
		
		if($use_lynx === false){
			
			$headers = [
				"User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"DNT: 1",
				//"Cookie: SOCS=CAESNQgCEitib3FfaWRlbnRpdHlmcm9udGVuZHVpc2VydmVyXzIwMjQwMzE3LjA4X3AwGgJlbiAEGgYIgM7orwY",
				"Connection: keep-alive",
				"Upgrade-Insecure-Requests: 1",
				"Sec-Fetch-Dest: document",
				"Sec-Fetch-Mode: navigate",
				"Sec-Fetch-Site: none",
				"Sec-Fetch-User: ?1",
				"Priority: u=1",
				"TE: trailers"
			];
						
			// use http2
			curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		}else{
			
			$headers = [
				"Accept: text/html, text/plain, text/sgml, */*;q=0.01",
				"Accept-Encoding: gzip, compress, bzip2",
				"Accept-Language: en",
				"User-Agent: Lynx/2.9.0dev.12 libwww-FM/2.14 SSL-MM/1.4.1 GNUTLS/3.7.8"
			];
		}
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);
		
		// follow redirects
		curl_setopt($curlproc, CURLOPT_FOLLOWLOCATION, true);

		$this->backend->assign_proxy($curlproc, $proxy);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		
		if($use_lynx){
			
			return mb_convert_encoding($data, "UTF-8", "ISO-8859-1");
		}
		
		return $data;
	}
	
	
	private function scrape_dimg($html){
		
		// get images loaded through javascript
		$this->dimg = [];
		
		preg_match_all(
			'/function\(\){google\.ldi=({.*?});/',
			$html,
			$dimg
		);
		
		if(isset($dimg[1])){
			
			foreach($dimg[1] as $i){
				
				$tmp = json_decode($i, true);
				foreach($tmp as $key => $value){
					
					$this->dimg[$key] =
						$this->unshit_thumb(
							$value
						);
				}
			}
		}
		
		// get additional javascript base64 images
		preg_match_all(
			'/var s=\'(data:image\/[^\']+)\';var ii=\[((?:\'[^\']+\',?)+)\];/',
			$html,
			$dimg
		);
		
		if(isset($dimg[1])){
			
			for($i=0; $i<count($dimg[1]); $i++){
				
				$delims = explode(",", $dimg[2][$i]);
				$string =
					$this->fuckhtml
					->parseJsString(
						$dimg[1][$i]
					);
				
				foreach($delims as $delim){
					
					$this->dimg[trim($delim, "'")] = $string;
				}
			}
		}
	}
	
	
	private function scrape_imagearr($html){
		// get image links arrays
		preg_match_all(
			'/\[[0-9]+,"([^"]+)",\["([^"]+)\",([0-9]+),([0-9]+)\],\["([^"]+)",([0-9]+),([0-9]+)\]/',
			$html,
			$image_arr
		);
		
		$this->image_arr = [];
		if(isset($image_arr[1])){
			
			for($i=0; $i<count($image_arr[1]); $i++){
				
				$original =
					$this->fuckhtml
					->parseJsString(
						$image_arr[5][$i]
					);
				
				if(
					preg_match(
						'/^x-raw-image/',
						$original
					)
				){
					
					// only add thumbnail, google doesnt have OG resolution
					$this->image_arr[$image_arr[1][$i]] = [
						[
							"url" =>
								$this->unshit_thumb(
									$this->fuckhtml
									->parseJsString(
										$image_arr[2][$i]
									)
								),
							"width" => (int)$image_arr[7][$i], // pass the OG image width & height
							"height" => (int)$image_arr[6][$i]
						]
					];
					
					continue;
				}
				
				$this->image_arr[$image_arr[1][$i]] =
					[
						[
							"url" => $original,
							"width" => (int)$image_arr[7][$i],
							"height" => (int)$image_arr[6][$i]
						],
						[
							"url" =>
								$this->unshit_thumb(
									$this->fuckhtml
									->parseJsString(
										$image_arr[2][$i]
									)
								),
							"width" => (int)$image_arr[4][$i],
							"height" => (int)$image_arr[3][$i]
						]
					];
			}
		}
	}
	
	
	private function getdimg($dimg){
		
		return isset($this->dimg[$dimg]) ? $this->dimg[$dimg] : null;
	}
	
	
	private function unshit_thumb($url, $get_bigger_res = false){
		// https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQINE2vbnNLHXqoZr3RVsaEJFyOsj1_BiBnJch-e1nyz3oia7Aj5xVj
		// https://i.ytimg.com/vi/PZVIyA5ER3Y/mqdefault.jpg?sqp=-oaymwEFCJQBEFM&rs=AMzJL3nXeaCpdIar-ltNwl82Y82cIJfphA
		
		$parts = parse_url($url);
		
		if(
			isset($parts["host"]) &&
			preg_match(
				'/(?:encrypted-)?tbn.*\.gstatic\.com/',
				$parts["host"]
			)
		){
			
			parse_str($parts["query"], $params);
			
			if(isset($params["q"])){
				
				if($get_bigger_res){
					
					// this method doesnt always work, but does work for wiki thumbnails
					return
						"https://" . $parts["host"] . "/images?q=tbn:" .
						$this->base64url_encode(
							substr(
								$this->base64url_decode(
									explode(
										":",
										$params["q"])[1]
									),
								0,
								29
							)
						);
				}else{
					
					return "https://" . $parts["host"] . "/images?q=" . $params["q"];
				}
			}
		}
		
		return $url;
	}
	
	
	private function parsestyles(){
		
		$styles = [];

		$style_div =
			$this->fuckhtml
			->getElementsByTagName(
				"style"
			);
		
		$raw_styles = "";
		
		foreach($style_div as $style){
			
			$raw_styles .= $style["innerHTML"];
		}
		
		// filter out media/keyframe queries
		$raw_styles =
			preg_replace(
				'/@\s*(?!font-face)[^{]+\s*{[\S\s]+?}\s*}/',
				"",
				$raw_styles
			);
		
		// get styles
		preg_match_all(
			'/(.+?){([\S\s]*?)}/',
			$raw_styles,
			$matches
		);
		
		for($i=0; $i<count($matches[1]); $i++){
			
			// get style values
			preg_match_all(
				'/([^:;]+):([^;]*?(?:\([^)]+\)[^;]*?)?)(?:;|$)/',
				$matches[2][$i],
				$values_regex
			);
			
			$values = [];
			for($k=0; $k<count($values_regex[1]); $k++){
				
				$values[trim($values_regex[1][$k])] =
					strtolower(trim($values_regex[2][$k]));
			}
			
			$names = explode(",", $matches[1][$i]);
			
			// h1,h2,h3 will each get their own array index
			foreach($names as $name){
				
				$name = trim($name, "}\t\n\r\0\x0B");
				
				foreach($values as $key => $value){
					
					$styles[$name][$key] = $value;
				}
			}
		}
		
		foreach($styles as $key => $values){
			
			$styles[$key]["_c"] = count($values);
		}
		
		$this->styles = $styles;
		
		// get CSS colors
		$this->css_colors = [];
		
		if(isset($this->styles[":root"])){
			
			foreach($this->styles[":root"] as $key => $value){
				
				$this->css_colors[$value] = strtolower($key);
			}
		}
	}
	
	
	
	private function getstyle($styles){
		
		$styles["_c"] = count($styles);
		
		foreach($this->styles as $style_key => $style_values){
			
			if(count(array_intersect_assoc($style_values, $styles)) === $styles["_c"] + 1){
				
				$style_key =
					explode(" ", $style_key);
				
				$style_key = $style_key[count($style_key) - 1];
				
				return
					ltrim(
						str_replace(
							[".", "#"],
							" ",
							$style_key
						)
					);
			}
		}
		
		return false;
	}
	
	
	
	private function getcolorvar($color){
		
		if(isset($this->css_colors[$color])){
			
			return $this->css_colors[$color];
		}
		
		return null;
	}
	
	
	
	public function web($get){
		
		if($get["npt"]){
			
			[$get, $proxy] = $this->backend->get($get["npt"], "web");
			
			try{
				$html =
					$this->get(
						$proxy,
						"https://www.google.com" . $get,
						[],
						true
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
			
		}else{
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$lang = $get["lang"];
			$older = $get["older"];
			$newer = $get["newer"];
			$spellcheck = $get["spellcheck"];
			$proxy = $this->backend->get_ip();
			
			$offset = 0;
			
			$params = [
				"q" => $search,
				"hl" => "en",
				"num" => 20
			];
			
			// country
			if($country != "any"){
				
				$params["gl"] = $country;
			}
			
			// nsfw
			$params["safe"] = $nsfw == "yes" ? "off" : "active";
			
			// language
			if($lang != "any"){
				
				$params["lr"] = "lang_" . $lang;
			}
			
			// generate tbs
			$tbs = [];
			
			// get date
			$older = $older === false ? null : date("m/d/Y", $older);
			$newer = $newer === false ? null : date("m/d/Y", $newer);
			
			if(
				$older !== null ||
				$newer !== null
			){
				
				$tbs["cdr"] = "1";
				$tbs["cd_min"] = $newer;
				$tbs["cd_max"] = $older;
			}
			
			// spellcheck filter
			if($spellcheck == "no"){
				
				$params["nfpr"] = "1";
			}
			
			if(count($tbs) !== 0){
				
				$params["tbs"] = "";
				
				foreach($tbs as $key => $value){
					
					$params["tbs"] .= $key . ":" . $value . ",";
				}
				
				$params["tbs"] = rtrim($params["tbs"], ",");
			}
			
			try{
				$html =
					$this->get(
						$proxy,
						"https://www.google.com/search",
						$params,
						true
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
			
			//$html = file_get_contents("scraper/google.html");
		}
		
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
		
		$this->fuckhtml->load($html);
		$this->detect_sorry();
		
		$this->parsestyles();
		
		$boxes =
			$this->fuckhtml
			->getElementsByClassName(
				$this->getstyle([
					"border" => "thin solid #dadce0",
					"padding" => "12px 16px 12px 16px",
					"margin-bottom" => "10px",
					"font-family" => "sans-serif"
				]),
				"div"
			);
		
		$skip_next = false;
		
		// get next page token
		$npt =
			$this->fuckhtml
			->getElementsByClassName(
				$this->getstyle([
					"border" => "thin solid #dadce0",
					"color" => "#70757a",
					"font-size" => "14px",
					"text-align" => "center",
					"table-layout" => "fixed",
					"width" => "100%"
				]),
				"table"
			);
		
		if(count($npt) !== 0){
			
			$this->fuckhtml->load($npt[0]);
			
			$as =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			foreach($as as $a){
				
				$text =
					$this->fuckhtml
					->getTextContent(
						$a
					);
				
				if(
					$text == "Next&nbsp;>" ||
					$text == ">"
				){
					
					$out["npt"] =
						$this->backend->store(
							$this->fuckhtml
							->getTextContent(
								$a["attributes"]["href"]
							),
							"web",
							$proxy
						);
				}
			}
			
			$this->fuckhtml->load($html);
		}
		
		$first_box = true;
		foreach($boxes as $box){
			
			$this->fuckhtml->load($box);
			
			if($first_box){
				
				//
				// Probe for word correction
				//
				$first_box = false;
				
				$txt =
					$this->fuckhtml
					->getTextContent($box);
				
				if(
					preg_match(
						'/^Showing results for /',
						$txt
					)
				){
					
					$as =
						$this->fuckhtml
						->getElementsByTagName(
							"a"
						);
					
					if(count($as) === 2){
						
						$out["spelling"] = [
							"type" => "including",
							"using" =>
								$this->fuckhtml
								->getTextContent(
									$as[0]
								),
							"correction" =>
								$this->fuckhtml
								->getTextContent(
									$as[1]
								)
						];
					}
					continue;
				}
			}
			
			// probe for custom container
			$container_title =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle([
						"font-weight" => "bold"
					])
				);
			
			if(count($container_title) !== 0){
				
				$container_title =
					strtolower(
						$this->fuckhtml
						->getTextContent(
							$container_title[0]
						)
					);
				
				if($container_title == "images"){
					
					//
					// Parse image carousel
					//
					$images =
						$this->fuckhtml
						->getElementsByClassName(
							$this->getstyle([
								"display" => "inline-block",
								"padding" => "2px",
								"padding-bottom" => "4px"
							]),
							"a"
						);
					
					foreach($images as $image){
						
						$this->fuckhtml->load($image);
						
						$image_data =
							$this->unshiturl(
								$image["attributes"]["href"],
								true
							);
						
						$img =
							$this->fuckhtml
							->getElementsByTagName(
								"img"
							)[0];
						
						$out["image"][] = [
							"title" =>
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$img["attributes"]["alt"]
									)
								),
							"source" =>	[
								[
									"url" => $image_data["url"],
									"width" => $image_data["image_width"],
									"height" => $image_data["image_height"]
								],
								[
									"url" =>
										$this->fuckhtml
										->getTextContent(
											$img["attributes"]["src"]
										),
									"width" => $image_data["thumb_width"],
									"height" => $image_data["thumb_height"]
								]
							],
							"url" => $image_data["ref"]
						];
					}
					
					continue;
				}
				
				if(
					$container_title == "related searches" ||
					$container_title == "people also search for"
				){
					
					$as =
						$this->fuckhtml
						->getElementsByClassName(
							$this->getstyle([
								"color" => "#202124",
								"font-size" => "13px",
								"line-height" => "20px"
							]),
							"span"
						);
					
					foreach($as as $a){
						
						$out["related"][] =
							$this->fuckhtml
							->getTextContent(
								$a
							);
					}
					continue;
				}
			}
			
			// probe for website link
			$link =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle([
						"color" => "#1967d2",
						"font-size" => "18px",
						"line-height" => "24px"
					]),
					"a"
				);
			
			if(count($link) !== 0){
				
				//
				// Parse search result
				//
				
				$this->fuckhtml->load($link[0]);
				
				$title =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle([
							"color" => "#1967d2",
							"font-size" => "18px",
							"line-height" => "24px"
						]),
						"span"
					);
				
				if(count($title) === 0){
					
					continue;
				}
				
				$this->fuckhtml->load($box);
				
				$sublinks = [];
				$table = [];
				
				$categories =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle([
							"color" => "#202124",
							"font-size" => "13px",
							"line-height" => "20px"
						]),
						"span"
					);
				
				$i = 0;
				foreach($categories as $category){
					
					$this->fuckhtml->load($category);
					
					// probe for sublinks
					$subs =
						$this->fuckhtml
						->getElementsByClassName(
							$this->getstyle([
								"color" => "#1967d2"
							]),
							"a"
						);
					
					if(count($subs) !== 0){
						
						foreach($subs as $sub){
							
							$url =
								$this->unshiturl(
									$this->fuckhtml
									->getTextContent(
										$sub["attributes"]["href"]
									)
								);
							
							if(
								preg_match(
									'/^https?:\/\//',
									$url
								)
							){
								
								$sublinks[] = [
									"title" =>
										$this->titledots(
											$this->fuckhtml
											->getTextContent(
												$sub
											)
										),
									"description" => null,
									"url" =>
										$this->unshiturl(
											$this->fuckhtml
											->getTextContent(
												$sub["attributes"]["href"]
											)
										),
									"date" => null
								];
							}
						}
						
						unset($categories[$i]);
					}
					
					$i++;
				}
				
				// get description & date
				$date = null;
				
				$categories = array_values($categories);
				
				//print_r($categories);
				
				$c = count($categories) - 1;
				
				$description =
					$this->fuckhtml
					->getTextContent(
						$categories[$c]
					);
				
				// remove last category since we're done with it
				unset($categories[$c]);
				
				// probe for date
				$description_tmp = explode("·", $description, 2);
				$date_tmp = strtotime(trim($description_tmp[0]));
				
				if(
					count($description_tmp) === 2 &&
					strlen($description_tmp[0]) <= 20 &&
					$date_tmp !== false
				){
					
					$description =
						ltrim(
							$this->titledots(
								$description_tmp[1]
							)
						);
					$date = $date_tmp;
				}else{
					
					$description =
						$this->titledots(
							$description
						);
				}
				
				// remaining categories should all be greytext
				if(count($categories) !== 0){
					
					$texts =
						explode(
							"·",
							preg_replace(
								'/\s+/',
								" ",
								$this->fuckhtml
								->getTextContent(
									$categories[0]
								)
							)
						);
					
					foreach($texts as $text){
						
						$text = trim($text);
						
						if(
							preg_match(
								'/^Rating ([0-9.]+)(?: \(([0-9,]+)\))?/',
								$text,
								$rating
							)
						){
							
							$table["Rating"] = $rating[1];
							if(isset($rating[2])){
								
								$table["Rating"] .= " (" . $rating[2] . " votes)";
							}
							
							continue;
						}
						
						if(stripos($text, "stock") !== false){
							
							$table["Stock"] = $text;
							continue;
						}
					}
				}
				
				$out["web"][] = [
					"title" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$title[0]
							)
						),
					"description" => $description,
					"url" =>
						$this->unshiturl(
							$link[0]["attributes"]["href"]
						),
					"date" => $date,
					"type" => "web",
					"thumb" => [
						"url" => null,
						"ratio" => null
					],
					"sublink" => $sublinks,
					"table" => $table
				];
				
				continue;
			}
			
			// parse wikipedia heads
			$wiki_title =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle([
						"color" => "#202124",
						"font-size" => "18px",
						"line-height" => "24px"
					]),
					"span"
				);
			
			if(count($wiki_title) !== 0){
				
				$wiki_title =
					$this->fuckhtml
					->getTextContent(
						$wiki_title[0]
					);
				
				if($wiki_title == "See results about"){
					
					// ignore
					continue;
				}
				
				if($wiki_title == "Top stories"){
										
					//
					// Parse news
					//
					$tds =
						$this->fuckhtml
						->getElementsByTagName(
							"td"
						);
					
					foreach($tds as $td){
						
						$this->fuckhtml->load($td);
						
						$a =
							$this->fuckhtml
							->getElementsByTagName(
								"a"
							);
						
						if(count($a) === 0){
							
							continue;
						}
						
						$title =
							$this->fuckhtml
							->getElementsByClassName(
								$this->getstyle([
									"color" => "#1967d2"
								]),
								"span"
							);
						
						if(count($title) === 0){
							
							continue;
						}
						
						$date = null;
						
						$meta_div =
							$this->fuckhtml
							->getElementsByClassName(
								$this->getstyle([
									"color" => "#70757a",
									"font-size" => "13px",
									"line-height" => "20px"
								]),
								"span"
							);
							
						$meta_div =
							explode(
								"·",
								$this->fuckhtml
								->getTextContent(
									$meta_div[count($meta_div) - 1]
								),
								2
							);
						
						if(count($meta_div) === 2){
							
							$date = strtotime($meta_div[count($meta_div) - 1]);
							
							if($date === false){
								
								$date = null;
							}
						}
						
						$out["news"][] = [
							"title" =>
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$title[0]
									)
								),
							"description" => null,
							"date" => $date,
							"thumb" => [
								"url" => null,
								"ratio" => null
							],
							"url" =>
								$this->unshiturl(
									$a[0]["attributes"]["href"]
								)
						];
					}
					continue;
				}
				
				//
				// Parse wikipedia heads
				//
				
				$table_div =
					$this->fuckhtml
					->getElementsByTagName(
						"table"
					);
				
				if(count($table_div) === 0){
					
					continue;
				}
				
				$this->fuckhtml->load($table_div[0]);
				
				// remove table from box
				$box["innerHTML"] =
					str_replace(
						$table_div[0]["outerHTML"],
						"",
						$box["innerHTML"]
					);
				
				// find wiki image
				$thumb = null;
				
				$img =
					$this->fuckhtml
					->getElementsByTagName(
						"img"
					);
				
				if(count($img) !== 0){
					
					$thumb =
						$this->unshit_thumb(
							$this->fuckhtml
							->getTextContent(
								$img[0]["attributes"]["src"]
							),
							true
						);
				}
				
				$tds =
					$this->fuckhtml
					->getElementsByTagName(
						"td"
					);
				
				$description = [];
				
				foreach($tds as $td){
					
					// probe for subtitle
					$this->fuckhtml->load($td);
					
					$subtext =
						$this->fuckhtml
						->getElementsByClassName(
							$this->getstyle([
								"color" => "#70757a",
								"font-size" => "13px",
								"line-height" => "20px"
							])
						);
					
					if(count($subtext) !== 0){
						
						$description[] = [
							"type" => "quote",
							"value" =>
								$this->fuckhtml
								->getTextContent(
									$subtext[0]
								)
						];
						break;
					}
				}
				
				$this->fuckhtml->load($box);
				
				// probe for word definition
				$lists =
					$this->fuckhtml
					->getElementsByTagName(
						"ol"
					);
				
				if(count($lists) !== 0){
					
					$description = [];
					
					foreach($lists as $list){
						
						$box["innerHTML"] =
							explode(
								$list["outerHTML"],
								$box["innerHTML"],
								2
							);
						
						if(
							count($box["innerHTML"]) === 1 ||
							trim($box["innerHTML"][0]) == "" 
						){
							
							break;
						}
						
						$description[] = [
							"type" => "title",
							"value" =>
								$this->fuckhtml
								->getTextContent(
									$box["innerHTML"][0]
								)
						];
						
						$this->fuckhtml->load($list);
						
						$lis =
							$this->fuckhtml
							->getElementsByTagName(
								"li"
							);
						
						$increment = 1;
						
						foreach($lis as $li){
							
							$this->fuckhtml->load($li);
							
							$list_items =
								$this->fuckhtml
								->getElementsByClassName(
									$this->getstyle([
										"color" => "#202124",
										"font-size" => "13px",
										"line-height" => "20px"
									])
								);
							
							$first_item = true;
							foreach($list_items as $it){
								
								if($first_item){
									
									$first_item = false;
									$c = count($description);
									
									if(
										$c !== 0 &&
										$description[$c - 1]["type"] == "text"
									){
										
										$description[$c - 1]["value"] .=
											"\n\n" .
											$increment . ". " . $this->fuckhtml
											->getTextContent(
												$it
											);
									}else{
										
										$description[] = [
											"type" => "text",
											"value" =>
												$increment . ". " . $this->fuckhtml
												->getTextContent(
													$it
												)
										];
									}
								}else{
									
									$description[] = [
										"type" => "quote",
										"value" =>
											$this->fuckhtml
											->getTextContent(
												$it
											)
									];
								}
								
								$increment++;
							}
						}
						
						$box["innerHTML"] = $box["innerHTML"][1];
					}
					
					$out["answer"][] = [
						"title" => $wiki_title,
						"description" => $description,
						"url" => null,
						"thumb" => null,
						"table" => [],
						"sublink" => []
					];
					
					continue;
				}
				
				// get separator between description and facts
				$separator =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle([
							"height" => "4px"
						]),
						"div"
					);
				
				$box_html = [];
				$table = [];
				
				if(count($separator) !== 0){
					
					$box_html =
						explode(
							$separator[0]["outerHTML"],
							$box["innerHTML"],
							2
						);
					
					if(count($box_html) === 2){
						
						$box["innerHTML"] = $box_html[0];
					}
					
					$this->fuckhtml->load($box_html[1]);
					
					// get all facts
					$facts =
						$this->fuckhtml
						->getElementsByTagName(
							"div"
						);
					
					foreach($facts as $fact){
						
						if($fact["level"] !== 1){ continue; }
						
						$fact =
							explode(
								":",
								$this->fuckhtml
								->getTextContent(
									$fact
								),
								2
							);
						
						if(count($fact) === 2){
							
							$table[trim(preg_replace('/\s+/', " ", $fact[0]))] =
								trim(preg_replace('/\s+/', " ", $fact[1]));
						}
					}
					
					$this->fuckhtml->load($box);
				}
				
				// remove wikipedia link
				$wiki_link =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle([
							"color" => "#1967d2"
						]),
						"a"
					);
				
				$url = null;
				if(count($wiki_link) !== 0){
					
					foreach($wiki_link as $link){
						
						if(
							strtolower(
								$this->fuckhtml
								->getTextContent(
									$link
								)
							) == "wikipedia"
						){
							
							$box["innerHTML"] =
								str_replace(
									$link["outerHTML"],
									"",
									$box["innerHTML"]
								);
							
							$url =
								$this->unshiturl(
									$link["attributes"]["href"]
								);
							
							$this->fuckhtml->load($box);
							break;
						}
					}
				}
				
				// remains of box should be description
				$description[] = [
					"type" => "text",
					"value" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$box
							)
						)
				];
				
				$out["answer"][] = [
					"title" => $wiki_title,
					"description" => $description,
					"url" => $url,
					"thumb" => $thumb,
					"table" => $table,
					"sublink" => []
				];
			}
		}
		
		return $out;
	}
	
	
	
	public function video($get){
		
		if($get["npt"]){
			
			[$params, $proxy] = $this->backend->get($get["npt"], "video");
			$params = json_decode($params, true);
			
		}else{
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$older = $get["older"];
			$newer = $get["newer"];
			$duration = $get["duration"];
			$quality = $get["quality"];
			$captions = $get["captions"];
			$proxy = $this->backend->get_ip();
			
			$params = [
				"q" => $search,
				"udm" => "7",
				"hl" => "en",
				"num" => 20
			];
			
			// country
			if($country != "any"){
				
				$params["gl"] = $country;
			}
			
			// nsfw
			$params["safe"] = $nsfw == "yes" ? "off" : "active";
			
			$tbs = [];
			
			// get date
			$older = $older === false ? null : date("m/d/Y", $older);
			$newer = $newer === false ? null : date("m/d/Y", $newer);
			
			if(
				$older !== null ||
				$newer !== null
			){
				
				$tbs["cdr"] = "1";
				$tbs["cd_min"] = $newer;
				$tbs["cd_max"] = $older;
			}
			
			// duration
			if($duration != "any"){
				
				$tbs[] = "dur:" . $duration;
			}
			
			// quality
			if($quality != "any"){
				
				$tbs[] = "hq:" . $quality;
			}
			
			// captions
			if($captions != "any"){
				
				$tbs[] = "cc:" . $captions;
			}
			
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] =
					implode(",", $tbs);
			}
		}
		
		try{
			$html =
				$this->get(
					$proxy,
					"https://www.google.com/search",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get HTML");
		}
		
		if(!isset($params["start"])){
			
			$params["start"] = 0;
		}
		$params["start"] += 20;
		
		$this->fuckhtml->load($html);
		
		//
		// Parse web video page
		//
		$this->detect_sorry();
		
		// parse all <style> tags
		$this->parsestyles();
		
		// get javascript images
		$this->scrape_dimg($html);
		
		$this->scrape_imagearr($html);
		
		$out = [
			"status" => "ok",
			"npt" =>
				$this->backend->store(
					json_encode($params),
					"videos",
					$proxy
				),
			"video" => [],
			"author" => [],
			"livestream" => [],
			"playlist" => [],
			"reel" => []
		];
		
		$search_div =
			$this->fuckhtml
			->getElementById(
				"center_col"
			);
		
		if($search_div === false){
			
			throw new Exception("Failed to grep search div");
		}
		
		$this->fuckhtml->load($search_div);
		
		$results =
			$this->fuckhtml
			->getElementsByClassName(
				$this->getstyle([
					"margin" => "0px 0px 30px"
				]),
				"div"
			);
		
		foreach($results as $result){
			
			$this->fuckhtml->load($result);
			
			$url =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			if(count($url) === 0){
				
				// no url, weird, continue
				continue;
			}
			
			$title =
				$this->fuckhtml
				->getElementsByTagName(
					"h3"
				);
			
			if(count($title) === 0){
				
				// no title, weird, continue
				continue;
			}
			
			// get description
			$description =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle([
						"-webkit-box-orient" => "vertical",
						"display" => "-webkit-box",
						"-webkit-line-clamp" => "2",
						"overflow" => "hidden",
						"word-break" => "break-word"
					]),
					"div"
				);
			
			if(count($description) === 0){
				
				$description = null;
			}else{
				
				$description =
					html_entity_decode(
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$description[0]
							)
						)
					);
			}
			
			// get author + date posted
			$metadiv =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle([
						"margin-top" => "12px"
					]),
					"div"
				);
			
			$author = null;
			$date = null;
			
			if(count($metadiv) !== 0){
				
				$metadiv =
					explode(
						"·",
						$this->fuckhtml
						->getTextContent(
							$metadiv[0]
						)
					);
				
				if(count($metadiv) === 3){
					
					$author = trim($metadiv[1]);
					$date = strtotime(trim($metadiv[2]));
				}elseif(count($metadiv) === 2){
					
					$author = trim($metadiv[0]);
					$date = strtotime(trim($metadiv[1]));
				}
			}
			
			$thumb = [
				"url" => null,
				"ratio" => null
			];
			
			$image =
				$this->fuckhtml
				->getElementsByTagName(
					"img"
				);
			
			$duration = null;
			
			if(
				count($image) !== 0 &&
				isset($image[0]["attributes"]["id"])
			){
				
				$thumb = [
					"url" => $this->getdimg($image[0]["attributes"]["id"]),
					"ratio" => "16:9"
				];
				
				// get duration
				$duration =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle([
							"background-color" => "rgba(0,0,0,0.6)",
							"color" => "#fff",
							"fill" => "#fff"
						])
					);
				
				if(count($duration) !== 0){
					
					$duration =
						$this->hms2int(
							$this->fuckhtml
							->getTextContent(
								$duration[0]
							));
				}else{
					
					$duration = null;
				}
			}
			
			$out["video"][] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$title[0]
						)
					),
				"description" => $description,
				"author" => [
					"name" => $author,
					"url" => null,
					"avatar" => null
				],
				"date" => $date,
				"duration" => $duration,
				"views" => null,
				"thumb" => $thumb,
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$url[0]["attributes"]["href"]
					)
			];
		}
		
		return $out;
	}
	
	
	
	public function news($get){
		
		if($get["npt"]){
			
			[$req, $proxy] = $this->backend->get($get["npt"], "news");
			/*parse_str(
				parse_url($req, PHP_URL_QUERY),
				$search
			);*/
			
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://www.google.com" . $req,
						[]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
			
		}else{
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$older = $get["older"];
			$newer = $get["newer"];
			$sort = $get["sort"];
			$proxy = $this->backend->get_ip();
			
			$params = [
				"q" => $search,
				"tbm" => "nws",
				"hl" => "en",
				"num" => "20"
			];
			
			// country
			if($country != "any"){
				
				$params["gl"] = $country;
			}
			
			// nsfw
			$params["safe"] = $nsfw == "yes" ? "off" : "active";
			
			$tbs = [];
			
			// get date
			$older = $older === false ? null : date("m/d/Y", $older);
			$newer = $newer === false ? null : date("m/d/Y", $newer);
			
			if(
				$older !== null ||
				$newer !== null
			){
				
				$tbs["cdr"] = "1";
				$tbs["cd_min"] = $newer;
				$tbs["cd_max"] = $older;
			}
			
			// relevance
			if($sort == "date"){
				
				$tbs["sbd"] = "1";
			}
					
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] = "";
				
				foreach($tbs as $key => $value){
					
					$params["tbs"] .= $key . ":" . $value . ",";
				}
				
				$params["tbs"] = rtrim($params["tbs"], ",");
			}
			
			//$html = file_get_contents("scraper/google-news.html");
			
			$html =
				$this->get(
					$proxy,
					"https://www.google.com/search",
					$params
				);
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		$this->fuckhtml->load($html);
		
		$this->detect_sorry();
		
		// get images
		$this->scrape_dimg($html);
		
		// parse styles
		$this->parsestyles();
		
		$center_col =
			$this->fuckhtml
			->getElementById(
				"center_col",
				"div"
			);
		
		if($center_col === null){
			
			throw new Exception("Could not grep result div");
		}
		
		$this->fuckhtml->load($center_col);
		
		// get next page
		$npt =
			$this->fuckhtml
			->getElementById(
				"pnnext",
				"a"
			);
		
		if($npt !== false){
			
			$out["npt"] =
				$this->backend->store(
					$this->fuckhtml
					->getTextContent(
						$npt["attributes"]
						["href"]
					),
					"news",
					$proxy
				);
		}
		
		$as =
			$this->fuckhtml
			->getElementsByAttributeName(
				"jsname",
				"a"
			);
		
		foreach($as as $a){
			
			$this->fuckhtml->load($a);
			
			// get title
			$title =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"role",
					"heading",
					"div"
				);
			
			if(count($title) === 0){
				
				continue;
			}
			
			$title =
				$this->titledots(
					$this->fuckhtml
					->getTextContent(
						$title[0]
					)
				);
			
			// get thumbnail
			$image =
				$this->fuckhtml
				->getElementsByAttributeName(
					"id",
					"img"
				);
			
			// check for padded title node, if found, we're inside a carousel
			$probe =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"padding" => "16px 16px 40px 16px"
						]
					),
					"div"
				);
			
			if(count($probe) !== 0){
				
				$probe = true;
			}else{
				
				$probe = false;
			}
			
			if(
				count($image) !== 0 &&
				!isset($image[0]["attributes"]["width"])
			){
				
				$thumb = [
					"url" =>
						$this->getdimg(
							$image[0]["attributes"]["id"]
						),
					"ratio" => $probe === true ? "16:9" : "1:1"
				];
			}else{
				
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}
			
			$description = null;
			
			if($probe === false){
				
				$desc_divs =
					$this->fuckhtml
					->getElementsByAttributeName(
						"style",
						"div"
					);
				
				foreach($desc_divs as $desc){
					
					if(
						strpos(
							$desc["attributes"]["style"],
							"margin-top:"
						) !== false
					){
						
						$description =
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$desc
								)
							);
						break;
					}
				}
			}
			
			// get author
			$author =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"overflow" => "hidden",
							"text-align" => "left",
							"text-overflow" => "ellipsis",
							"white-space" => "nowrap",
							"margin-bottom" => "8px"
						]
					),
					"div"
				);
			
			if(count($author) !== 0){
				
				$author =
					$this->fuckhtml
					->getTextContent(
						$author[0]
					);
			}else{
				
				$author = null;
			}
			
			// get date
			$date = null;
			
			$date_div =
				$this->fuckhtml
				->getElementsByAttributeName(
					"style",
					"div"
				);
			
			foreach($date_div as $d){
				
				$this->fuckhtml->load($d);
				
				$span =
					$this->fuckhtml
					->getElementsByTagName(
						"span"
					);
				
				if(
					strpos(
						$d["attributes"]["style"],
						"bottom:"
					) !== false
				){
					
					$date =
						strtotime(
							$this->fuckhtml
							->getTextContent(
								$span[count($span) - 1]
							)
						);
					break;
				}
			}
			
			$out["news"][] = [
				"title" => $title,
				"author" => $author,
				"description" => $description,
				"date" => $date,
				"thumb" => $thumb,
				"url" =>
					$this->unshiturl(
						$a["attributes"]
						["href"]
					)
			];
		}
		
		return $out;
	}
	
	
	
	
	public function image($get){
		
		// generate parameters
		if($get["npt"]){
			
			[$params, $proxy] =
				$this->backend->get(
					$get["npt"],
					"images"
				);
			
			$params = json_decode($params, true);
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
			
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$time = $get["time"];
			$size = $get["size"];
			$ratio = $get["ratio"];
			$color = $get["color"];
			$type = $get["type"];
			$format = $get["format"];
			$rights = $get["rights"];
			
			$params = [
				"q" => $search,
				"udm" => "2" // get images
			];
			
			// country (image search uses cr instead of gl)
			if($country != "any"){
				
				$params["cr"] = "country" . strtoupper($country);
			}
			
			// nsfw
			$params["safe"] = $nsfw == "yes" ? "off" : "active";
			
			// generate tbs
			$tbs = [];
			
			// time
			if($time != "any"){
				
				$tbs["qdr"] = $time;
			}
			
			// size
			if($size != "any"){
				
				$params["imgsz"] = $size;
			}
			
			// ratio
			if($ratio != "any"){
				
				$params["imgar"] = $ratio;
			}
			
			// color
			if($color != "any"){
				
				if(
					$color == "color" ||
					$color == "trans"
				){
					
					$params["imgc"] = $color;
				}elseif($color == "bnw"){
					
					$params["imgc"] = "gray";
				}else{
					
					$tbs["ic"] = "specific";
					$tbs["isc"] = $color;
				}
			}
			
			// type
			if($type != "any"){
				
				$tbs["itp"] = $type;
			}
			
			// format
			if($format != "any"){
				
				$params["as_filetype"] = $format;
			}
			
			// rights (tbs)
			if($rights != "any"){
				
				$tbs["sur"] = $rights;
			}
			
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] = "";
				
				foreach($tbs as $key => $value){
					
					$params["tbs"] .= $key . ":" . $value . ",";
				}
				
				$params["tbs"] = rtrim($params["tbs"], ",");
			}
		}
		/*
		$handle = fopen("scraper/page.html", "r");
		$html = fread($handle, filesize("scraper/page.html"));
		fclose($handle);*/
		
		try{
			$html = 
				$this->get(
					$proxy,
					"https://www.google.com/search",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get search page");
		}
		
		$this->fuckhtml->load($html);
		
		$this->detect_sorry();
		
		// get javascript images
		$this->scrape_imagearr($html);
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		$images =
			$this->fuckhtml
			->getElementsByClassName(
				"ivg-i",
				"div"
			);
		
		foreach($images as $div){
			
			$this->fuckhtml->load($div);
			
			$image =
				$this->fuckhtml
				->getElementsByTagName("img")[0];
			
			// make sure we dont attempt to show an image we dont have data for
			if(
				isset($div["attributes"]["data-docid"]) &&
				isset($this->image_arr[$div["attributes"]["data-docid"]])
			){
				
				$source =
					$this->image_arr[
						$div["attributes"]["data-docid"]
					];
			}else{
				
				continue;
			}
			
			$out["image"][] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$image["attributes"]["alt"]
						)
					),
				"source" => $source,
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$div["attributes"]["data-lpage"]
					)
			];
		}
		
		// as usual, no way to check if there is a next page reliably
		if(count($out["image"]) > 50){
			
			if(!isset($params["start"])){
				
				$params["start"] = 10;
			}else{
				
				$params["start"] += 10;
			}
			
			$out["npt"] =
				$this->backend
				->store(
					json_encode($params),
					"image",
					$proxy
				);
		}
		
		return $out;
	}
	
	private function unshiturl($url, $return_size = false){
		
		// decode
		$url =
			$this->fuckhtml
			->getTextContent(
				$url
			);
		
		$url_parts = parse_url($url);
		
		if(isset($url_parts["query"])){
			
			parse_str($url_parts["query"], $query);
		}else{
			
			$query = [];
		}
		
		if(
			!isset(
				$url_parts["host"]
			) ||
			stripos($url_parts["host"], "google.") !== false
		){
			
			// no host, we have a tracking url
			if(isset($query["imgurl"])){
				
				$url = $query["imgurl"];
			}
			elseif(isset($query["q"])){
				
				$url = $query["q"];
			}
		}
		
		// rewrite URLs to remove extra tracking parameters
		$domain = parse_url($url, PHP_URL_HOST);
		
		if(
			preg_match(
				'/wikipedia.org$/',
				$domain
			)
		){
			
			// rewrite wikipedia mobile URLs to desktop
			$url =
				$this->replacedomain(
					$url,
					preg_replace(
						'/([a-z0-9]+)(\.m\.)/',
						'$1.',
						$domain
					)
				);
		}
		
		elseif(
			preg_match(
				'/imdb\.com$|youtube\.[^.]+$/',
				$domain
			)
		){
			
			// rewrite imdb and youtube mobile URLs too
			$url =
				$this->replacedomain(
					$url,
					preg_replace(
						'/^m\./',
						"",
						$domain
					)
				);
			
		}
		
		elseif(
			preg_match(
				'/play\.google\.[^.]+$/',
				$domain
			)
		){
			
			// remove referrers from play.google.com
			$u_query = parse_url($url, PHP_URL_QUERY);
			if($u_query !== null){
				
				parse_str($u_query, $u_query);
				if(isset($u_query["referrer"])){ unset($u_query["referrer"]); }
				if(isset($u_query["hl"])){ unset($u_query["hl"]); }
				if(isset($u_query["gl"])){ unset($u_query["gl"]); }
				
				$query = http_build_query($query);
				
				$url =
					str_replace(
						$u_query,
						$u_query,
						$url
					);
			}
		}
		
		elseif(
			preg_match(
				'/twitter\.com$/',
				$domain
			)
		){
			// remove more referrers from twitter.com
			$u_query = parse_url($url, PHP_URL_QUERY);
			if($u_query !== null){
				
				parse_str($u_query, $u_query);
				if(isset($u_query["ref_src"])){ unset($u_query["ref_src"]); }
				
				$u_query = http_build_query($u_query);
				
				$url =
					str_replace(
						$oldquery,
						$u_query,
						$url
					);
			}
		}
		
		elseif(
			preg_match(
				'/maps\.google\.[^.]+/',
				$domain
			)
		){
			
			if(stripos($url, "maps?") !== false){
				
				$u_query = parse_url($url, PHP_URL_QUERY);

				if($u_query !== null){
					
					parse_str($u_query, $u_query);
					
					if(isset($u_query["daddr"])){
						
						$url =
							"https://maps.google.com/maps?daddr=" .
							urlencode($u_query["daddr"]);
					}
				}
			}
		}
		
		if($return_size){
			
			return [
				"url" => $url,
				"ref" => isset($query["imgrefurl"]) ? $query["imgrefurl"] : null,
				"thumb_width" => isset($query["tbnw"]) ? (int)$query["tbnw"] : null,
				"thumb_height" => isset($query["tbnh"]) ? (int)$query["tbnh"] : null,
				"image_width" => isset($query["w"]) ? (int)$query["w"] : null,
				"image_height" => isset($query["h"]) ? (int)$query["h"] : null
			];
		}
		
		return $url;
	}
	
	private function replacedomain($url, $domain){
		
		return
			preg_replace(
				'/(https?:\/\/)([^\/]+)/',
				'$1' . $domain,
				$url
			);
	}
	
	private function titledots($title){
		
		return trim($title, " .\t\n\r\0\x0B…");
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
	
	function base64url_decode($data){
		
		$b64 = strtr($data, "-_", "+/");
		$pad = strlen($b64) % 4;
		if ($pad) $b64 .= str_repeat("=", 4 - $pad);
		
		return base64_decode($b64);
	}

	function base64url_encode($data){
		
		return rtrim(strtr(base64_encode($data), "+/", "-_"), "=");
	}
	
	private function detect_sorry(){
		
		$captcha_form =
			$this->fuckhtml
			->getElementById(
				"captcha-form",
				"form"
			);
		
		if($captcha_form !== false){
			
			throw new Exception("Google returned a captcha");
		}
	}
}
