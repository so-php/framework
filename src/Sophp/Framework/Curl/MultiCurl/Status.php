<?php


namespace Sophp\Framework\Curl\MultiCurl;


class Status {
    /**
     * @var resource[]
     */
    protected $handles;

    protected $multiHandle;

    protected $stillRunning;

    /**
     * @param $multiHandle
     * @param $stillRunning
     * @param array $handles
     */
    public function __construct($multiHandle, & $stillRunning, $handles = array()){
        $this->multiHandle = $multiHandle;
        $this->handles = $handles;
        $this->stillRunning = $stillRunning;
    }

    /**
     * Check if all the curl requests have completed
     * @return bool
     */
    public function isComplete(){
        return $this->stillRunning ? true : false;
    }

    /**
     * blocks until the next response is received (or times out)
     */
    public function waitOne(){
        curl_multi_info_read($this->multiHandle, $startMessagesInQueue);
        do {
            $status = curl_multi_exec($this->multiHandle, $this->stillRunning);
            $info = curl_multi_info_read($this->multiHandle, $messagesInQueue);
            if (false !== $info) {
                //var_dump($info);
            }
        } while (
            ($status === CURLM_CALL_MULTI_PERFORM || $this->stillRunning)
            && $startMessagesInQueue == $messagesInQueue
        );
    }

    /**
     * blocks until all response have been received (or timeout)
     */
    public function waitAll(){
        do {
            $status = curl_multi_exec($this->multiHandle, $this->stillRunning);
            $info = curl_multi_info_read($this->multiHandle);
            if (false !== $info) {
                //var_dump($info);
            }
        } while ($status === CURLM_CALL_MULTI_PERFORM || $this->stillRunning);
    }

    /**
     *
     * Non blocking, returns the current aggregated list, will be subject to
     * change until status is complete.
     * @return array
     */
    public function response(){
        $response = array();
        foreach($this->handles as $handle){
            $response[curl_getinfo($handle, CURLINFO_EFFECTIVE_URL)] = curl_multi_getcontent($handle);
        }
        return $response;
    }

    public function __destruct(){
        // clear out any unfinished requests
        $this->waitAll();

        foreach($this->handles as $handle){
            curl_multi_remove_handle($this->multiHandle, $handle);
            curl_close($handle);
        }
        curl_multi_close($this->multiHandle);
    }
} 