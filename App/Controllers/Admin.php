<?php

namespace App\Controllers;

use \Core\View;
use App\Models\InterestDAO;

class Admin extends \Core\Controller
{
    
    public function indexAction()
    {
        $interest_suggestion = InterestDAO::selectOneSuggestionInterestNotRevised();
        
        if ($interest_suggestion) {
            
            $allInterestCount    = InterestDAO::countAllInterestSuggestion();
            $equalsInterestCount = InterestDAO::countAllInterestSuggestionThatAreEquals($interest_suggestion[0]['name']);
            
            View::renderTemplate('Admin/index.html', array(
                'interest_suggestion' => $interest_suggestion,
                'allInterestCount' => $allInterestCount,
                'equalsInterestCount' => $equalsInterestCount
            ));
            
        } else {
            View::renderTemplate('Admin/zerowork.html');
        }
    }
    
    public function manualAction()
    {
        $allInterestOficials    = InterestDAO::getAllInterestOficials();
        $allInterestSuggestions = InterestDAO::getAllInterestSuggestions();
        
        $allInterests = array_merge($allInterestOficials, $allInterestSuggestions);
        
        View::renderTemplate('Admin/manual.html', array(
            'allInterests' => $allInterests
        ));
    }
    
    public function remaptagAction()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name_tag']) && !empty($_POST['name_tag']) && isset($_POST['input_tag']) && !empty($_POST['input_tag']) && isset($_POST['id_tag']) && !empty($_POST['id_tag']) && isset($_POST['checkbox']) && !empty($_POST['checkbox'])) {
            
            $results = InterestDAO::checkIfInterestIsOfficial($_POST['input_tag']);
            
            if (!empty($results)) {
                
                if ($_POST['checkbox'] == 'true') {
                    echo InterestDAO::remapInterestSuggestionToOfficialMultiple($_POST['name_tag'], $results[0]['id_interest']);
                } else {
                    echo InterestDAO::remapInterestSuggestionToOfficial($_POST['id_tag'], $results[0]['id_interest']);
                }
                
            } else {
                
                if ($_POST['checkbox'] == 'true') {
                    echo InterestDAO::remapInterestSuggestionToRevisedMultiple($_POST['id_tag'], $_POST['input_tag'], $_POST['name_tag']);
                } else {
                    echo InterestDAO::remapInterestSuggestionToRevised($_POST['id_tag'], $_POST['input_tag'], $_POST['id_tag']);
                }
                
            }
            
        } else {
            header("Location: /iDent/admin");
        }
        
    }
    
    public function remaptagmanualAction()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data_id']) && !empty($_POST['data_id']) && isset($_POST['data_type']) && !empty($_POST['data_type']) && isset($_POST['input_tag']) && !empty($_POST['input_tag'])) {
            
            $results = InterestDAO::checkIfInterestIsOfficial($_POST['input_tag']);
            
            if ($_POST['data_type'] == 'official') {
                echo InterestDAO::remapManualOfficial($_POST['data_id'], $_POST['input_tag']);
            } else {
                echo InterestDAO::remapManualSuggestion($_POST['data_id'], $_POST['input_tag']);
            }
            
        } else {
            header("Location: /iDent/admin");
        }
        
    }
    
}