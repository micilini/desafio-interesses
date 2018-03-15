<?php

namespace App\Models;

use PDO;

class InterestDAO extends \Core\Model
{
    
    public static function checkIfInterestIsOfficial($interest)
    {
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('SELECT id_interest FROM interest WHERE UPPER(name) LIKE UPPER(:interest)');
            $stmt->bindValue(":interest", $interest);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
    }
    
    public static function checkIfInterestIsAnActualSuggestion($name_interest)
    {
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('SELECT id_interest_suggestion FROM `interest_suggestion` WHERE UPPER(name) LIKE UPPER(:interest)');
            $stmt->bindValue(":interest", $name_interest);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
    }
    
    public static function insertUserInterest($id_interest, $is_suggestion = 0)
    {
        
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('INSERT INTO interest_user (`userID`, `interestID`, `interestIsSuggestion`, `date_created`) VALUES (3, :id_interest, :is_suggestion, :datetime)');
            $stmt->bindValue(":id_interest", $id_interest);
            $stmt->bindValue(":is_suggestion", $is_suggestion);
            $stmt->bindValue(":datetime", date("Y-m-d H:i:s"));
            $stmt->execute();
            
            return true;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function addNewSuggestionInterest($name_interest)
    {
        
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('INSERT INTO `interest_suggestion` (`userID`, `name`, `date_created`) VALUES (3, :name_interest, :datetime)');
            $stmt->bindValue(":name_interest", $name_interest);
            $stmt->bindValue(":datetime", date("Y-m-d H:i:s"));
            $stmt->execute();
            
            return $db->lastInsertId();
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function selectOneSuggestionInterestNotRevised()
    {
        
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('SELECT * FROM interest_suggestion WHERE revised = 0 ORDER BY date_created DESC LIMIT 0,1');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function countAllInterestSuggestion()
    {
        
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('SELECT count(*) AS total FROM interest_suggestion WHERE revised = 0');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function countAllInterestSuggestionThatAreEquals($interest_name)
    {
        
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('SELECT count(*) AS total FROM interest_suggestion WHERE revised = 0 AND UPPER(name) LIKE UPPER(:name)');
            $stmt->bindValue(":name", $interest_name);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function remapInterestSuggestionToOfficialMultiple($name_tag, $id_tag_official)
    {
        
        try {
            $db = static::getDB();
            
            $stmtSelect = $db->prepare('SELECT id_interest_suggestion FROM `interest_suggestion` WHERE UPPER(name) LIKE UPPER(:interest)');
            $stmtSelect->bindValue(":interest", $name_tag);
            $stmtSelect->execute();
            $results = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
            
            $allIdsSuggestion = array();
            
            foreach ($results as $key => $value) {
                array_push($allIdsSuggestion, $value['id_interest_suggestion']);
            }
            
            $allIdsSuggestion = implode(",", $allIdsSuggestion);
            
            $stmtUpdate = $db->prepare('UPDATE `interest_user` SET `interestID` = :id_tag_official, `interestIsSuggestion` = false WHERE interestID in (' . $allIdsSuggestion . ')');
            $stmtUpdate->bindValue(":id_tag_official", $id_tag_official);
            $stmtUpdate->execute();
            
            $stmtDelete = $db->prepare('DELETE FROM `interest_suggestion` WHERE id_interest_suggestion in (' . $allIdsSuggestion . ')');
            $stmtDelete->execute();
            
            return true;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function remapInterestSuggestionToOfficial($id_tag, $id_interest_official)
    {
        
        try {
            $db = static::getDB();
            
            $stmtSelect = $db->prepare('SELECT id_interest_user FROM `interest_user` WHERE userID = :uID AND interestID = :iID');
            $stmtSelect->bindValue(":uID", 3);
            $stmtSelect->bindValue(":iID", $id_tag);
            $stmtSelect->execute();
            $results = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
            
            $stmtUpdate = $db->prepare('UPDATE `interest_user` SET `interestID` = :id_interest_official, `interestIsSuggestion` = false WHERE id_interest_user = :id_official');
            $stmtUpdate->bindValue(":id_interest_official", $id_interest_official);
            $stmtUpdate->bindValue(":id_official", $results[0]['id_interest_user']);
            $stmtUpdate->execute();
            
            $stmtDelete = $db->prepare('DELETE FROM `interest_suggestion` WHERE id_interest_suggestion = :id_tag');
            $stmtDelete->bindValue(":id_tag", $id_tag);
            $stmtDelete->execute();
            
            return true;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function remapInterestSuggestionToRevised($id_tag, $input_tag, $id_sugg)
    {
        
        try {
            $db = static::getDB();
            
            $stmtUpdate = $db->prepare('UPDATE `interest_suggestion` SET `name` = :input_tag, `revised` = true WHERE id_interest_suggestion = :id_sugg');
            $stmtUpdate->bindValue(":input_tag", $input_tag);
            $stmtUpdate->bindValue(":id_sugg", $id_sugg);
            $stmtUpdate->execute();
            
            return true;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function remapInterestSuggestionToRevisedMultiple($id_tag, $input_tag, $name_tag)
    {
        
        try {
            $db = static::getDB();
            
            $stmtUpdate = $db->prepare('UPDATE `interest_suggestion` SET `name` = :input_tag, `revised` = true WHERE UPPER(name) LIKE UPPER(:name_tag)');
            $stmtUpdate->bindValue(":input_tag", $input_tag);
            $stmtUpdate->bindValue(":name_tag", $name_tag);
            $stmtUpdate->execute();
            
            return true;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function getAllInterestOficials($fields = '*')
    {
        
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('SELECT '.$fields.' FROM interest');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function getAllInterestSuggestions()
    {
        
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('SELECT * FROM interest_suggestion');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function remapManualOfficial($data_id, $input_tag)
    {
        
        try {
            $db = static::getDB();
            
            $stmtUpdate = $db->prepare('UPDATE `interest` SET `name` = :name_tag WHERE id_interest = :id_interest');
            $stmtUpdate->bindValue(":name_tag", $input_tag);
            $stmtUpdate->bindValue(":id_interest", $data_id);
            $stmtUpdate->execute();
            
            return true;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
    public static function remapManualSuggestion($data_id, $input_tag)
    {
        
        try {
            $db = static::getDB();
            
            $stmtUpdate = $db->prepare('UPDATE `interest_suggestion` SET `name` = :name_tag WHERE id_interest_suggestion = :id_interest');
            $stmtUpdate->bindValue(":name_tag", $input_tag);
            $stmtUpdate->bindValue(":id_interest", $data_id);
            $stmtUpdate->execute();
            
            return true;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
	
	public static function getAllInterestOficialsByWords($piece_word)
    {
        
        try {
            $db = static::getDB();
            
            $stmt = $db->prepare('SELECT name FROM interest WHERE UPPER(name) LIKE UPPER(:piece_word)');
			$stmt->bindValue(":piece_word", $piece_word.'%');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        }
        catch (PDOException $e) {
            return false;
            //echo $e->getMessage(); Podemos salvar em um arquivo de log
        }
        
    }
    
}
