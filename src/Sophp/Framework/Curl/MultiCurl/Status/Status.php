<?php


namespace Sophp\Framework\Curl\MultiCurl\Status;


class Status {
    /**
     * @var resource[]
     */
    protected $handles;

    /**
     * @var resource
     */
    protected $multiHandle;

    /**
     * @var bool
     */
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
        $this->curl_multi_info_read($this->multiHandle, $startMessagesInQueue);
        do {
            $status = $this->curl_multi_exec($this->multiHandle, $this->stillRunning);
            $info = $this->curl_multi_info_read($this->multiHandle, $messagesInQueue);
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
            $status = $this->curl_multi_exec($this->multiHandle, $this->stillRunning);
            $info = $this->curl_multi_info_read($this->multiHandle, $messagesInQueue);
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
            $response[$this->curl_getinfo($handle, CURLINFO_EFFECTIVE_URL)] = $this->curl_multi_getcontent($handle);
        }
        return $response;
    }

    public function __destruct(){
        // clear out any unfinished requests
        $this->waitAll();

        foreach($this->handles as $handle){
            $this->curl_multi_remove_handle($this->multiHandle, $handle);
            $this->curl_close($handle);
        }
        $this->curl_multi_close($this->multiHandle);
    }

    /**
     * Native function wrapper for testing
     * @param $multiHandle
     * @param $messagesInQueue
     * @return array
     */
    protected function curl_multi_info_read($multiHandle, & $messagesInQueue){
        return curl_multi_info_read($multiHandle, $messagesInQueue);
    }

    /**
     * Native function wrapper for testing
     * @param $multiHandle
     * @param $stillRunning
     * @return int
     */
    protected function curl_multi_exec($multiHandle, & $stillRunning) {
        return curl_multi_exec($multiHandle, $stillRunning);
    }

    /**
     * Native function wrapper for testing
     * @param $handle
     * @return mixed
     */
    protected function curl_getinfo($handle){
        return curl_getinfo($handle);
    }

    /**
     * Native function wrapper for testing
     * @param $handle
     * @return string
     */
    protected function curl_multi_getcontent($handle) {
        return curl_multi_getcontent($handle);
    }

    /**
     * Native function wrapper for testing
     * @param $multiHandle
     * @param $curlHandle
     * @return int
     */
    protected function curl_multi_remove_handle($multiHandle, $curlHandle){
        return curl_multi_remove_handle($multiHandle, $curlHandle);
    }

    /**
     * Native function wrapper for testing
     * @param $handle
     */
    protected function curl_close($handle){
        curl_close($handle);
    }

    /**
     * Native function wrapper for testing
     * @param $handle
     */
    protected function curl_multi_close($handle){
        curl_multi_close($handle);
    }
} 