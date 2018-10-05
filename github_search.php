<?php

class searchGit extends LanguageSummary {

	public $searchTerm = ''; //Global search term

	use Plucker;
	use GitHandler;

	function __construct($searchStr) {		
			$this->searchTerm = $searchStr;		
		}

	public function searcher()
	{
		$a  = $this->getData();
		arsort($a);
		return $a;
	}
}
 
class LanguageSummary  {
 	public $output = array();

	protected  function getData()
	{
		$this->out[] =  $this->getGitRepo(1); // grap first iteration and stores total_count
/*
you must first registrater and add details to curl in order to get a higher rate limit per API call with GITHub. When registered you can remove the bit  where it shows 20;// below and replace with:  ceil(($out[0]['total_count']/100 -1)); This will ensure all interations of repository  are run.
*/
		$total = 20; // ceil(($out[0]['total_count']/100 -1));

		if($total > 1){
			$iterationTotal =  $total;
			for ($x = 0; $x <= $iterationTotal; $x++) { //Loop through repo
					$this->output[] =  $this->getGitRepo($x);
					sleep(2);
			 }
		}
 		$out = $this->output; //Get merged output
		foreach($out as $item => $value){ // pluck out lang value
		 	$repoArr[] = array_column($value['items'], 'language');
		}
		return array_count_values($this->flatten($repoArr));
	}
}

trait Plucker { // pluck out language values from array
	public function flatten(array $array) 
	{
	    $return = array();
	    array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
	    return $return;
	}
} 

trait GitHandler { //calls API
	public function getGitRepo($page_number)
	{
		$searchStr = $this->searchTerm; // retieve global search term
		$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.github.com/search/repositories?q=".$searchStr."&per_page=100&page=".$page_number,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 20,
				CURLOPT_TIMEOUT => 3000,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"Cache-Control: no-cache",
					"user-agent: http://developer.github.com/v3/#user-agent-required)"
				),
			)
		);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return  json_decode($response, true);
		}
	}
}
