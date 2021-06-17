<?php
include_once FS_ROOT.'config.php';
require "DBController.php";
class SessionDao
{
    function getAuthByUsername($username) {

        $db_handle = new DBController();
        $username = mysqli_real_escape_string($db_handle->getConnection(), $username);

        $query = "SELECT `INT`, `USER` , `PASS` , `EQUIPE` , `EQUIPESIM`, `ADMIN` FROM `".DB_TABLE."` WHERE `USER` = ?";
        $result = $db_handle->runQuery($query, 's', array($username));
        return $result;
    }
    
    function updateAuth($teamId, $remoteAddress, $lastUpdated) {
        $db_handle = new DBController();
        $query = "UPDATE `".DB_TABLE."` SET `LAST`=?,`IP`=? WHERE `INT`=?";

        $result = $db_handle->update($query, 'ssi', array($lastUpdated, $remoteAddress, $teamId));
        
        return $result;
    }
    
    function getTokenByUsername($username,$expired) {
        $db_handle = new DBController();
        $username = mysqli_real_escape_string($db_handle->getConnection(), $username);
        $query = "Select * from gmo_session join gmo ON gmo_session.team_id = gmo.INT where gmo.USER = ? and is_expired = ?";
        $result = $db_handle->runQuery($query, 'si', array($username, $expired));
        return $result;
    }
    
    function getToken($token, $teamId) {
        $db_handle = new DBController();
        $token = mysqli_real_escape_string($db_handle->getConnection(), $token);
        $query = "SELECT * FROM gmo_session where token = ? and team_id = ?";
        $result = $db_handle->runQuery($query, 'si', array($token, $teamId));
        return $result;
    }
    
    function getTokenByTeamId($teamId,$expired) {
        $db_handle = new DBController();

        $query = "Select * from gmo_session where team_id = ? and is_expired = ?";
        $result = $db_handle->runQuery($query, 'ii', array($teamId, $expired));
        return $result;
    }
    
    function markAsExpiredByTeam($teamId) {
        $db_handle = new DBController();
        $query = "UPDATE gmo_session SET is_expired = ? where expiry_date > now() and team_id = ? and is_expired = 0";
        $expired = 1;
        $result = $db_handle->update($query, 'ii', array($expired, $teamId));
        return $result;
    }
    
    function markAsExpired($tokenId) {
        $db_handle = new DBController();
        $query = "UPDATE gmo_session SET is_expired = ? WHERE id = ?";
        $expired = 1;
        $result = $db_handle->update($query, 'ii', array($expired, $tokenId));
        return $result;
    }
    
    function insertToken($teamId, $token, $expiry_date) {
        $db_handle = new DBController();
        $query = "INSERT INTO gmo_session (team_id, token, expiry_date) values (?, ?, ?)";
        $result = $db_handle->insert($query, 'iss', array($teamId, $token, $expiry_date));
        return $result;
    }
    
    function update($query) {
        mysqli_query($this->conn,$query);
    }
    
}

