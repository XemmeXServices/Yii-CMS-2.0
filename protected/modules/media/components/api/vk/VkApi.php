<?php
class VkApi extends ApiAbstract
{
    protected $api;
    protected $criteriaClass = 'VkApiCriteria';

    public $pk;

    public $oid;
    public $id;
    public $hash;
    public $hd;


    public function getPlayerUrl()
    {
        return 'http://vk.com/video_ext.php?' . http_build_query([
            'oid'  => $this->oid,
            'id'   => $this->id,
            'hash' => $this->hash
        ]);
    }


    /**
     * @return Zend_Gdata_YouTube
     */
    public function getApi()
    {
//        return $this->api;
    }


    public function save()
    {
        return true;
    }


    public function getUrl()
    {
        throw new CException('no implemented yet');
    }


    public function getHref()
    {
        throw new CException('no implemented yet');
    }


    /**
     * @param YouTubeApiCriteria $criteria
     *
     * @return array
     */
    public function findAll($criteria)
    {
        throw new CException('no implemented yet');
    }


    protected function _populate($data)
    {
        foreach ($data as $key => $val)
        {
            $this->$key = $val;
        }
    }


    public function count($criteria)
    {
        return 10000;
    }


    public function search($props = [])
    {
        $criteria = clone $this->getDbCriteria();
        $criteria->mergeWith($props);
        $dp = new YouTubeApiDataProvider(new YouTubeApi(), [
            'criteria' => $criteria
        ]);
        return $dp;
    }


    public function attributeNames()
    {
        return [
            'title',
            'img',
            'player_url',
            'pk',
            'oid',
            'id',
            'hash',
            'hd'
        ];
    }


    public function findByPk($pk)
    {
        $this->beforeFind();
        parse_str($pk, $data);
        return $this->populateRecord($data);
    }


    public function parse($source)
    {
        preg_match_all('/(video_ext.php\?)([a-z0-9\-_&=]+)/i', $source, $matches);
        if (isset($matches[2]))
        {
            $matches[2] = array_values(array_unique($matches[2]));
            foreach ($matches[2] as $key => $id)
            {
                return $id;
            }
        }
        return false;
    }


    public function getThumb($hq = true)
    {
    }


}