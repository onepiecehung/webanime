<?php
//link to get direct link
    $url = 'https://plus.google.com/photos/114399510702664967296/albums/6115782833804325377/6116031685963004018?pid=6116031685963004018&oid=114399510702664967296';
	$getuser = explode('photos/', $url);
	$getuser = explode('/', $getuser[1]);
	echo $userid = $getuser[0];
	$getid = explode('?pid=', $url);
	$getid = explode('&', $getid[1]);
	$id = $getid[0];
	$url = 'https://picasaweb.google.com/data/feed/tiny/user/'.$userid.'/photoid/'.$id .'?alt=jsonm';
	$data = get_curl($url);
	if($id){
		$test1=explode('"gphoto$id":"'.$id,$data);
		$test1=explode('"gphoto$id',$test1[1]);
		$data = $test1[0];
	}
	$patten = '/\{"url":"https?:\/\/redirector.googlevideo.com\/videoplayback([^\}]+)/';
	preg_match_all($patten,$data,$match);
	if (count($match[0]) > 0)
	{
		foreach($match[0] as $item)
		{
			$itemJS =json_decode($item.'}', true);             
			if ($itemJS['height']>300 && $itemJS['height'] < 400 && !isset($itemmedium)) $itemmedium = $itemJS['url'];
			if ($itemJS['height']>=400 && $itemJS['height'] < 700 && !isset($itemlarge)) $itemlarge = $itemJS['url'];
			if ($itemJS['height']>=700 && !isset($itemhd)) $itemhd = $itemJS['url'];
            if ($itemJS['height']>=1060 && !isset($itemfullhd)) $itemfullhd = $itemJS['url'];													
		}
		if (!isset($itemmedium))
		{
			$itemJS =json_decode($match[0][count($match[0])-1].'}', true);  
			$itemmedium = $itemJS['url'];
		}
	}  
?>