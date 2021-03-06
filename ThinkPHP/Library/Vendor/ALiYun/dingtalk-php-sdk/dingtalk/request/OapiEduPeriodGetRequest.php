<?php
/**
 * dingtalk API: dingtalk.oapi.edu.period.get request
 * 
 * @author auto create
 * @since 1.0, 2018.11.23
 */
class OapiEduPeriodGetRequest
{
	/** 
	 * 学段ID
	 **/
	private $periodId;
	
	private $apiParas = array();
	
	public function setPeriodId($periodId)
	{
		$this->periodId = $periodId;
		$this->apiParas["period_id"] = $periodId;
	}

	public function getPeriodId()
	{
		return $this->periodId;
	}

	public function getApiMethodName()
	{
		return "dingtalk.oapi.edu.period.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->periodId,"periodId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
