<?php
/**
 * dingtalk API: dingtalk.oapi.user.getDeptMember request
 * 
 * @author auto create
 * @since 1.0, 2018.08.13
 */
class OapiUserGetDeptMemberRequest
{
	/** 
	 * a
	 **/
	private $deptId;
	
	private $apiParas = array();
	
	public function setDeptId($deptId)
	{
		$this->deptId = $deptId;
		$this->apiParas["deptId"] = $deptId;
	}

	public function getDeptId()
	{
		return $this->deptId;
	}

	public function getApiMethodName()
	{
		return "dingtalk.oapi.user.getDeptMember";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
