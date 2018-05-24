<?php

    
  if(!function_exists('jam_menit'))
  {   
    function jam_menit($time)
    {
      $p=explode(":",$time);
      return $p[0].":".$p[1];
    }
  }

  if(!function_exists('mix_2Date'))
  {    
    function mix_2Date($tgl1,$tgl2,$format="us")
    {
      $pecahTgl1 = explode("-",$tgl1);
      $pecahTgl2 = explode("-",$tgl2);
      $result="";
      if($format='us')
      {
        if($tgl1!=$tgl2)
        {
          if($pecahTgl1[0]==$pecahTgl2[0])
          {
            if($pecahTgl1[1]==$pecahTgl2[1])
            {
              $bulan = $pecahTgl1[1];
              $thn = $pecahTgl1[0];
              $result = $pecahTgl1[2] . " - " . $pecahTgl2[2] . " " . get_monthName($bulan,"id") . " " . $thn;
            }        
            else
            {
              $thn = $pecahTgl1[0];
              $result = $pecahTgl1[2] . " " . get_monthName($pecahTgl1[1],"id") . " - " . $pecahTgl2[2] . " " . get_monthName($pecahTgl2[1],"id") . " " . $thn;        
            }
          }
          else
          {
              $result = $pecahTgl1[2] . " " . get_monthName($pecahTgl1[1],"id") . " " . $pecahTgl1[0] . " - " . $pecahTgl2[2] . " " . get_monthName($pecahTgl2[1],"id") . " " . $pecahTgl2[0];          
          }
        }
        else
        {
           $result = $pecahTgl1[2]." ".get_monthName($pecahTgl1[1],"id")." ".$pecahTgl1[0];
        }
      }
      
      return $result;
    }
  }

  if(!function_exists('mix_2Month'))
  {    
    function mix_2Month($tgl1,$tgl2)
    {
      $result="";
      $pecahTgl1 = explode("-",$tgl1);
      $pecahTgl2 = explode("-",$tgl2);
      if($pecahTgl1[1]==$pecahTgl2[1])
      {
        $result=strtoupper(get_monthName($pecahTgl1[0],"indonesia"))." S/D ".strtoupper(get_monthName($pecahTgl2[0],"indonesia")). " ".$pecahTgl1[1];
      }
      else
      {
        $result=strtoupper(get_monthName($pecahTgl1[0],"indonesia"))." ".$pecahTgl1[1]." S/D ".strtoupper(get_monthName($pecahTgl2[0],"indonesia"))." ".$pecahTgl2[1];
      }
      
      return $result;
    }
  }
  
  if(!function_exists('indo_date_format'))
  {
    function indo_date_format($data,$type)
    {    
      $str_len = strLen($data);
      $dd="";
      $mm="";
      $yyyy="";
      $result="";
      
      $dd = substr($data,-2,2);
      $mm = substr($data,5,2);
      $yyyy = substr($data,0,4);      
      
      if($type=="longDate")
      {        
        $MM = get_monthName($mm,"id");
        $result = $dd . " " . $MM . " " . $yyyy;
      }
      else if($type=="withDayName")
      {
        $MM = get_monthName($mm,"id");
        $dn = get_dayName($data);      
        $result = $dn.", " . $dd . " " . $MM . " " . $yyyy; 
      }
      else if($type=="shortDate")
      {
        $result = $dd."-".$mm."-".$yyyy;
      }
      return $result;
    }
  }

  if(!function_exists('us_date_format'))
  {
    function us_date_format($data)
    {    
      $str_len = strLen($data);
      $dd="";
      $mm="";
      $yyyy="";
      $result="";
      
      $dd = substr($data,0,2);
      $mm = substr($data,3,2);      
      $yyyy = substr($data,6,4);
            
      $result = $yyyy."-".$mm."-".$dd;
      return $result;
    }
  }
  
  if(!function_exists('get_monthName'))
  {
    function get_monthName($bulan,$tipe='id')
    {
      $bulan_ = (int)$bulan;
      $arr_monthNumber = array(1,2,3,4,5,6,7,8,9,10,11,12);

      if(in_array($bulan_,$arr_monthNumber))
      {
        $arr_monthName = array(
                      1=>array('id'=>'Januari','us'=>'January'),
                      2=>array('id'=>'Februari','us'=>'February'),
                      3=>array('id'=>'Maret','us'=>'March'),
                      4=>array('id'=>'April','us'=>'April'),
                      5=>array('id'=>'Mei','us'=>'May'),
                      6=>array('id'=>'Juni','us'=>'June'),
                      7=>array('id'=>'Juli','us'=>'July'),
                      8=>array('id'=>'Agustus','us'=>'August'),
                      9=>array('id'=>'September','us'=>'September'),
                      10=>array('id'=>'Oktober','us'=>'October'),
                      11=>array('id'=>'November','us'=>'November'),
                      12=>array('id'=>'Desember','us'=>'December')
                      );
        
        return $arr_monthName[$bulan_][$tipe];
      }
      else
        return $bulan;

    }
  }

  if(!function_exists('check_date_format'))
  {
    function check_date_format($tgl,$separate="-",$format="indonesia")
    {
      if(strlen($tgl)<10)
        return false;
      else
      {
        if($format=="indonesia")
        {
          $pecah=explode($separate,$tgl);
          if(strlen($pecah[0])==2 && strlen($pecah[1])==2 && strlen($pecah[2])==4)
            return true;
          else
            return false;          
        }
        else
        {
          $pecah=explode($separate,$tgl);
          if($pecah[2]==2 && $pecah[1]==2 && $pecah[0]==4)        
            return true;
          else
            return false;
        }
      }
    }
  }
  
  
  if(!function_exists('get_dayName'))
  {
    function get_dayName($tanggal)
    {
      $d = substr($tanggal,8,2);
      $m = substr($tanggal,5,2);
      $y = substr($tanggal,0,4);
      $n = date('w',mktime(0,0,0,$m,$d,$y));
  	
      switch($n)
      {
        case "0":$hari="Minggu";break;
        case "1":$hari="Senin";break;
        case "2":$hari="Selasa";break;
        case "3":$hari="Rabu";break;
        case "4":$hari="Kamis";break;
        case "5":$hari="Jumat";break;
        case "6":$hari="Sabtu";break;        
      }
      return $hari;
    }
  }

  function firstOfMonth($month='',$year='') 
  {
    $month = ($month==''?date('m'):$month);
    $year = ($year==''?date('Y'):$year);
    return date("Y-m-d", strtotime($month.'/01/'.$year.' 00:00:00'));
  }

  function lastOfMonth($month='',$year='') {
    $month = ($month==''?date('m'):$month);
    $year = ($year==''?date('Y'):$year);
    return date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($month.'/01/'.$year.' 00:00:00'))));
  }

?>
