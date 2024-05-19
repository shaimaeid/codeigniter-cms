<?php
class adv3D {
     // property declaration
    public $title = 'Advertisment Title';
	public $img = 'no-image.gif';
	public $desc = 'This is the long description';
	public $auth ='New user';
	public $price ='200';
	public $type ='';
	public $purpose ='';
	public $advertiser ='';
	public $phone1 ='';
	public $phone2 ='';
	public $start_date ='';
	public $end_date ='';
	public $url ='';
	public $realestate_type ='';
	public $spot_id ='';
	public $place ='';
	public $area ='';
	public $rooms ='';
	public $path_rooms='';
	public $_floor ='';
	public $finishing ='';
	public $swf ='';
	

    // method declaration
    public function displayTitle() {
        echo $this->title;
    }
	public function displayImg() {
        echo $this->img;
    }
	public function displayDesc() {
        echo $this->desc;
    }
	public function displayPrice() {
        echo $this->price;
    }
	public function displayType() {
        echo $this->type;
    }

	public function displayPurpose() {
        echo $this->purpose;
    }
	public function displayAdvertiser() {
        echo $this->advertiser;
    }
	public function displayPhone1() {
        echo $this->phone1;
    }
	public function displayPhone2() {
        echo $this->phone2;
    }

	public function displayStart_date() {
        echo $this->start_date;
    }
	public function displayEnd_date() {
        echo $this->end_date;
    }
	public function displayUrl() {
        echo $this->url ;
    }
	public function displayPlace() {
        echo $this->place ;
    }
	public function displayArea() {
        echo $this->area ;
    }
		public function displayRooms() {
        echo $this->rooms ;
    }
	public function displayFloor() {
        echo $this->_floor ;
    }
	public function displayPaths() {
        echo $this->path_rooms ;
    }
	function getAdv($id){
		$sql="select * from `adv` where `id`=".$id." ;";
		//echo $sql;
		$result = mysql_query($sql);

		while ($row = mysql_fetch_array($result)) {
		$advid=stripslashes($row['id']);
		$this->title=stripslashes($row['title']);
		$this->img=stripslashes($row['realestate_image']);
		$this->desc=stripslashes($row['description']);
		$this->price=stripslashes($row['price']);
		$this->advertiser=stripslashes($row['advertiser_type']);
		$this->phone1=stripslashes($row['phone_1']);
		$this->phone2=stripslashes($row['phone_2']);
		$this->type=stripslashes($row['type']);
		$this->purpose=stripslashes($row['purpose']);
		$this->start_date=stripslashes($row['start_date']);
		$this->end_date=stripslashes($row['end_date']);
		$this->url=stripslashes($row['url']);
		$this->type=stripslashes($row['realestate_type']);
		$this->spot_id=stripslashes($row['spot_id']);
		$this->place=stripslashes($row['place']);
		$this->area=stripslashes($row['area']);
		$this->rooms=stripslashes($row['rooms']);
		$this->path_rooms=stripslashes($row['path_rooms']);
		$this->_floor=stripslashes($row['floor']);
		$this->finishing=stripslashes($row['finishing']);
		$this->swf=stripslashes($row['swf']);	
		
}
}
public function displaySwf() {
		$x=trim($this->swf);
		if(!empty($x))
		{
		echo '<h2 class="det-title" style="margin-top:5px;">:SWF  </h2>';
		echo '<div class="adv_vid">';
		echo '<iframe width="450" height="450" src="admin/swf/'.$this->swf.'" frameborder="0" allowfullscreen></iframe>';
		echo '</div>' ;
		echo '<div class="adv_rights">';
		echo '<p><span class="title">ملحوظة : </span> التصاميم مسئولية المستخدمين الذين ارسلوا الصور لتصميمها</p>';
		echo '</div>';
		}else{
		
		}

    }
}
?>

