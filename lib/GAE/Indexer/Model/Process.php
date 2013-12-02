<?

class GAE_Indexer_Model_Process extends Mage_Index_Model_Process
{
    public function unlock()
    {
        return $this;
    }

    public function lockAndBlock()
    {
        return $this;
    }

    public function lock()
    {
        return $this;
    }

    public function isLocked()
    {
        return false;
    }


}