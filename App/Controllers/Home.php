<?php

namespace App\Controllers;

use \Core\View;
use App\Models\InterestDAO;

class Home extends \Core\Controller
{
    
    protected function before()
    {
        //echo "(before) ";
        //return false;
    }
    
    protected function after()
    {
        //echo " (after)";
    }
	
	public function initialAction()
	{
		View::renderTemplate('Home/initial.html');
	}
    
    public function indexAction()
    {
        View::renderTemplate('Home/index.html');
    }
    
    public function finishAction()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data_json']) && !empty($_POST['data_json'])) {
            $piecesDatas = explode(",", $_POST['data_json']);
            View::renderTemplate('Home/finish.html', array(
                'datas' => $piecesDatas
            ));
        } else {
            header("Location: /iDent/");
        }
    }
    
    public function inserttagsAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['interest']) && !empty($_POST['interest'])) {
            
            $interest = json_decode($_POST['interest']);
            
            if (count($interest) < 3 || count(array_unique($interest)) < count($interest)) {
                echo 'Error';
                return;
            }
            
            echo self::addNewTags($interest);
            
        } else {
            header("Location: /iDent/");
        }
    }
    
    private static function addNewTags($interest)
    {
        
        foreach ($interest as $value) {
            
            $results = InterestDAO::checkIfInterestIsOfficial($value);
            
            if (!empty($results)) {
                
                if (!InterestDAO::insertUserInterest($results[0]['id_interest']))
                    return false;
                
            } else {
                
                $returnedId = InterestDAO::addNewSuggestionInterest($value);
                if (!InterestDAO::insertUserInterest($returnedId, 1))
                    return false;
                
            }
        }
        
        return true;
        
    }
	
	public function returnAllInterestsAction(){
	
	  $currentWords = self::getCurrentWords();
      $allInterestsNames = InterestDAO::getAllInterestOficialsByWords($currentWords);
	
	  if(is_array($allInterestsNames)){
		echo json_encode($allInterestsNames);
	  }

	}
    
	private static function getCurrentWords(){
		$parts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($parts['query'], $query);
        return $query['phrase'];
	}
	
}
