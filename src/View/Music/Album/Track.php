<?php
namespace View\Music\Album;

use Model;
use Mustache\IteratorPresenter as Presenter;


/**
 * View: music/album/<id>
 */
class Track extends \View\Music\Album
{
	public function __construct(string $id)
	{
		$this->id = $id;
		$this->track = Model::music()->track($id);
		
		$this->track->credits = new Presenter($this->track->credits);

		$this->track->parts = new Presenter($this->track->parts ?: [], true, function($item)
			{
				$val = &$item['value'];

				$item['title'] = array_remove($val, 'title');
				foreach($val as $k => $v)
					$val[$k] = preg_split('%\s*/\s*%', $v, null, PREG_SPLIT_NO_EMPTY);

				return $item;
			});
		
		parent::__construct($this->track->album_id);
	}

}
