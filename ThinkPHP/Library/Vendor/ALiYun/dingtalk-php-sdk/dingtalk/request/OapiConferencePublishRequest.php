<?php
/**
 * dingtalk API: dingtalk.oapi.conference.publish request
 * 
 * @author auto create
 * @since 1.0, 2018.11.24
 */
class OapiConferencePublishRequest
{
	/** 
	 * 会务id
	 **/
	private $conferenceId;
	
	/** 
	 * 操作用户id
	 **/
	private $userid;
	
	private $apiParas = array();
	
	public function setConferenceId($conferenceId)
	{
		$this->conferenceId = $conferenceId;
		$this->apiParas["conference_id"] = $conferenceId;
	}

	public function getConferenceId()
	{
		return $this->conferenceId;
	}

	public function setUserid($userid)
	{
		$this->userid = $userid;
		$this->apiParas["userid"] = $userid;
	}

	public function getUserid()
	{
		return $this->userid;
	}

	public function getApiMethodName()
	{
		return "dingtalk.oapi.conference.publish";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->conferenceId,"conferenceId");
		RequestCheckUtil::checkNotNull($this->userid,"userid");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
