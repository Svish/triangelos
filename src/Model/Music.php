<?php


/**
 * Music model.
 */
class Model_Music extends Model
{
	public function all()
	{
		$webshop = Model::webshop();

		foreach(Data_Album::index() as $id)
		{
			$x = Data::album($id);

			// Adjust urls
			array_walk_recursive($x, function(&$v, $k)
			{
				if($k == 'url')
					$v = 'music/'.$v;
			});

			// Add webshop items, if any
			$x->webshop_items = $webshop->items($x->id);
			
			yield $x;
		}
	}


	public function latest()
	{
		$count = 2;
		foreach($this->all() as $album)
		{
			yield $album;
			if(--$count == 0)
				return;
		}
	}

	public function album($id)
	{
		foreach($this->all() as $album)
			if($album->id == $id)
				return $album;
	}
}
