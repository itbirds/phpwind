<?php
/**
 * 贴子收藏
 *
 * @fileName: PwCollectDao.php
 * @author: dongyong<dongyong.ydy@alibaba-inc.com>
 * @license: http://www.phpwind.com
 * @version: $Id
 * @lastchange: 2015-01-09 14:58:16
 * @desc: 
 **/

class PwCollectDao extends PwBaseDao {
    protected $_pk = 'collect_id';
	protected $_table = 'collect_content';
    protected $_dataStruct = array('collect_id','created_userid','fid','tid','created_time');

    /**
     * @access public
     * @return void
     */
    public function addCollect($data){
        if (!($data = $this->_filterStruct($data))) return false;
        $sql = $this->_bindSql('INSERT INTO %s SET %s', $this->getTable(), $this->sqlSingle($data));
        $smt = $this->getConnection()->execute($sql);
        return $this->getConnection()->lastInsertId();
    }

    public function countCollectByUid($uid) {
        $sql = $this->_bindTable('SELECT COUNT(*) as sum FROM %s WHERE created_userid=?');
        $smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($uid));
	}

    public function getCollectByUid($uid, $limit, $offset){
        $sql = $this->_bindTable('SELECT collect_id,tid FROM %s WHERE created_userid=? ORDER BY collect_id DESC', $this->getTable(), $this->sqlLimit($limit, $offset) );
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll(array($uid)); 
    }

    public function getCollectByUidAndTid($uid, $tid){
        $sql = $this->_bindTable('SELECT collect_id,tid FROM %s WHERE created_userid=? AND tid=?', $this->getTable());
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($uid, $tid)); 
    }

    public function deleteCollectByUidAndTid($uid, $tid){
        $sql = $this->_bindSql('DELETE FROM %s WHERE created_userid=%s AND tid=%s', $this->getTable(), $uid, $tid );
        return $this->getConnection()->execute($sql);
    }

}