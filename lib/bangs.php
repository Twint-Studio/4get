<?php

class bangs {
	
	private $engines = [];
	private $bang_map = [];
	
	public function __construct() {
		// Load engines.json
		$json = file_get_contents(__DIR__ . '/../static/engines.json');
		$this->engines = json_decode($json, true);
		
		// Build bang map
		foreach ($this->engines as $engine) {
			if (!isset($engine['t'])) continue;
			
			$engine_data = [
				'url' => $engine['u'],
				'domain' => $engine['d'],
				'subs' => []
			];
			
			// Build sub-bangs map (convert to lowercase for case-insensitive matching)
			if (isset($engine['sb']) && is_array($engine['sb'])) {
				foreach ($engine['sb'] as $sub) {
					$engine_data['subs'][strtolower($sub['b'])] = $sub;
				}
			}
			
			// Map primary bang (convert to lowercase for case-insensitive matching)
			$this->bang_map[strtolower($engine['t'])] = $engine_data;
			
			// Map alternate bangs (ts field)
			if (isset($engine['ts']) && is_array($engine['ts'])) {
				foreach ($engine['ts'] as $alt_bang) {
					$this->bang_map[strtolower($alt_bang)] = $engine_data;
				}
			}
		}
	}
	
	/**
	 * Resolve a query with bangs into a redirect URL
	 * Returns null if no bang is found, otherwise returns the URL
	 */
	public function resolve($query) {
		if (empty(trim($query))) {
			return null;
		}
		
		$primary = null;
		$words = preg_split('/\s+/', trim($query));
		$search = [];
		$params = [];
		
		for ($i = 0; $i < count($words); $i++) {
			$word = $words[$i];
			$name = preg_replace('/^!|!$/', '', $word);
			$name_lower = strtolower($name);
			
			// Check if word is a bang (starts or ends with !)
			if (!preg_match('/^!|!$/', $word)) {
				$search[] = $word;
				continue;
			}
			
			// If no primary bang set yet and this is a valid bang
			if (!$primary && isset($this->bang_map[$name_lower])) {
				$primary = $name_lower;
				continue;
			}
			
			// If primary bang is set, check for sub-bangs
			if ($primary) {
				$engine = $this->bang_map[$primary];
				
				if (!isset($engine['subs'][$name_lower])) {
					continue;
				}
				
				$sub = $engine['subs'][$name_lower];
				$value = '';
				
				// Determine how to parse the sub-bang value
				if (isset($sub['l'])) {
					if ($sub['l'] == -1) {
						// Consume all remaining words
						$value = implode(' ', array_slice($words, $i + 1));
						$i = count($words);
					} elseif ($sub['l'] > 0) {
						// Consume next N words
						$value = implode(' ', array_slice($words, $i + 1, $sub['l']));
						$i += $sub['l'];
					} else {
						// l = 0, use default or predefined value
						$value = isset($sub['v']) ? $sub['v'] : (isset($sub['d']) ? $sub['d'] : '');
					}
				} else {
					$value = isset($sub['v']) ? $sub['v'] : (isset($sub['d']) ? $sub['d'] : '');
				}
				
				$params[$name_lower] = [
					'value' => $value,
					'url_param' => isset($sub['u']) ? $sub['u'] : null
				];
			}
		}
		
		// No bang found
		if (!$primary) {
			return null;
		}
		
		$engine = $this->bang_map[$primary];
		
		// If no search terms and no params, return just the domain
		if (empty($search) && empty($params)) {
			return 'https://' . $engine['domain'];
		}
		
		// Build the URL
		$search_string = implode(' ', $search);
		$url_template = $engine['url'];
		
		// Replace search placeholder
		$url = str_replace('{{{s}}}', 'PLACEHOLDER_SEARCH', $url_template);
		
		// Parse URL to add sub-bang parameters
		$parsed = parse_url($url);
		parse_str(isset($parsed['query']) ? $parsed['query'] : '', $query_params);
		
		// Add sub-bang parameters
		foreach ($params as $name => $param_data) {
			if ($param_data['url_param']) {
				$query_params[$param_data['url_param']] = $param_data['value'];
			}
		}
		
		// Rebuild URL
		$scheme = isset($parsed['scheme']) ? $parsed['scheme'] . '://' : 'https://';
		$host = isset($parsed['host']) ? $parsed['host'] : '';
		$path = isset($parsed['path']) ? $parsed['path'] : '';
		$fragment = isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '';
		
		$final_url = $scheme . $host . $path;
		
		if (!empty($query_params)) {
			$final_url .= '?' . http_build_query($query_params);
		}
		
		$final_url .= $fragment;
		
		// Replace placeholder with actual search term
		$final_url = str_replace(
			'PLACEHOLDER_SEARCH', 
			rawurlencode($search_string),
			$final_url
		);
		
		// Fix double-encoded slashes if needed
		$final_url = str_replace('%2F', '/', $final_url);
		
		return $final_url;
	}
	
	/**
	 * Check if a query contains a bang
	 */
	public function has_bang($query) {
		if (empty(trim($query))) {
			return false;
		}
		
		$words = preg_split('/\s+/', trim($query));
		
		foreach ($words as $word) {
			if (preg_match('/^!|!$/', $word)) {
				$name = preg_replace('/^!|!$/', '', $word);
				if (isset($this->bang_map[strtolower($name)])) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Extract the primary bang from a query
	 */
	public function get_primary_bang($query) {
		if (empty(trim($query))) {
			return null;
		}
		
		$words = preg_split('/\s+/', trim($query));
		
		foreach ($words as $word) {
			if (preg_match('/^!|!$/', $word)) {
				$name = preg_replace('/^!|!$/', '', $word);
				if (isset($this->bang_map[strtolower($name)])) {
					return strtolower($name);
				}
			}
		}
		
		return null;
	}
}
