<?php
    
  
    function get_ip()
    {    
      $arrayHost = array('HTTP_CLIENT_IP','HTTP_X_REAL_IP','REMOTE_ADDR',
                          'HTTP_FORWARDED_FOR','HTTP_X_FORWARDED,FOR',
                          'HTTP_X_CLUSTER_CLIENT_IP','HTTP_FORWARDED');  
      foreach($arrayHost as $key)
      {
        if(array_key_exists($key,$_SERVER)==true)
        {
          if(filter_var($_SERVER[$key],FILTER_VALIDATE_IP)==true)
          {
            $ip = $_SERVER[$key];
            break;
          } 
        }
      }
      return $ip;
    }
  
    function clear_over_whitespace($param)
    {
      $result='';
      $x=explode(' ',$param);
      for($i=0;$i<count($x);$i++)
      {     
        if(ord($x[$i])!=0)
        {
          $result.=$x[$i].' ';
        }     
      }
      return trim($result);
    }
  

    function hide_some_char($param)
    {   
      $result='';
      $len=strlen($param);
      if($len>1)      
      {
        $hlen=(($len-($len%2))/2);
        $phlen=$len-$hlen;
        for($i=0;$i<$len;$i++)
        {
          $result.=($i<$phlen?substr($param,$i,1):'x');
        }
      }
      else
      {
        $result=$param;
      }
      return $result;
    }  
  

    function clear_white_space($param)
    {
      $result='';
      for($i=0;$i<strlen($param);$i++)
      {
        $char=substr($param,$i,1);
        if($char!=' ')
          $result.=$char;
      }
      return trim($result);
    }    

    function limit_char($str,$limit)
    {
      $str=strip_tags($str);
      if(strlen($str)>$limit)
      {
        $string="";      
        for($i=0;$i<$limit;$i++)
        {
          $string.=substr($str,$i,1);
        }
        $string .="..";
      }
      else
      {
        $string=$str;
      }
      return $string;
    }

    function limit_words($str,$max,$limit)
    {
      $p=explode(" ",strip_tags($str));
      if(count($p)>$max)
      {
        $string="";
        for($i=0;$i<$limit;$i++)
        {          
          $string.=$p[$i]." ";
        }
        $string.='...';
      }
      else
      {
        $string=$str;
      }
      return $string;
    }

    function str_delimiters($str,$del)
    {
      $e=explode(" ",$str);
      $string="";
      if(count($e)>1)
      {
        $specialChar=array('!','@','#','$','%','^','&','*','(',')','_','-','`');
        for($i=0;$i<count($e);$i++)
        {
          if(!in_array($e[$i],$specialChar))
            $string.=$e[$i].$del;
        }
        $string=$this->del_lastChar($string);
      }
      else
        $string=$str;
      
      return $string;
    }

    function del_lastChar($str)
    {
      $string=substr($str,0,strlen($str)-1);
      return $string;
    }

    function parse_array($array,$ini,$del)
    {
      $string='';
      foreach($array as $key=>$value)
      {
        $string.= $key.$ini.$value.$del;
      }
      $string = substr($string,0,strlen($string)-1);
      return $string;    
    }    

    function generate_array($string,$ini,$del)
    {
      $array=array();
      $main=explode($del,$string);
      for($i=0;$i<count($main);$i++)
      {
        $e = explode($ini,$main[$i]);
        $array[$e[0]]=$e[1];
      }
    
      return $array;
    }

    function reverse_string($str)
    {
      $result="";
      for($i=strlen($str)-1;$i>=0;$i--)
      {
        $result .= substr($str,$i,1);
      }     
      return $result;
    }

    function thousand_format($str)
    {
      $revString = $this->reverse_string($str);
      $kar="";
      $result="";
      $string="";
      for($i=0;$i<strlen($str);$i++)
      {
        $kar = substr($revString,$i,1);
        if($i%3==0 && $i!=0)
          $string .= ".";
          
        $string .= $kar;
      }
      $result = $this->reverse_string($string);
      return $result;
    }

    function NumToRomawi($num)
    {
      
      $result = '';
      $iromawi = array('','I','II','III','IV','V','VI','VII','VIII','IX','X',20=>'XX',30=>'XXX',40=>'XL',50=>'L',
                      60=>'LX',70=>'LXX',80=>'LXXX',90=>'XC',100=>'C',200=>'CC',300=>'CCC',400=>'CD',500=>'D',600=>'DC',700=>'DCC',
                      800=>'DCCC',900=>'CM',1000=>'M',2000=>'MM',3000=>'MMM');

      if(array_key_exists($num,$iromawi))
      {
        $result = $iromawi[$num];
      }
      elseif($num >= 11 && $num <= 99)
      {
        $i = $num % 10;
        $result = $iromawi[$num-$i] . NumToRomawi($num % 10);
      }
      elseif($num >= 101 && $num <= 999)
      {
        $i = $num % 100;
        $result = $iromawi[$num-$i] . NumToRomawi($num % 100);
      }
      else
      {
        $i = $num % 1000;
        $result = $iromawi[$num-$i] . NumToRomawi($num % 1000);
      }
      return $result;
    }

    function NumToWords($num)
    {   
      $num=abs($num);
      $numerik=array('','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh','sebelas');
      $result='';
      
      if($num<12)
      {
        $result=$numerik[$num];
      }
      else if($num<20)
      {
        $result=NumToWords($num-10)." belas";
      }
      else if($num<100)
      {
        $result=NumToWords($num/10)." puluh ".NumToWords($num % 10);
      }
      else if($num<200)
      {
        $result='Seratus '.NumToWords($num - 100);
      }
      else if($num<1000)
      {
        $result=NumToWords($num/100)." ratus ".NumToWords($num % 100);
      }
      else if($num<2000)
      {
        $result='Seribu '.NumToWords($num - 1000);        
      }
      else if($num<1000000)
      {
        $result=NumToWords($num/1000)." ribu ".NumToWords($num % 1000);
      }
      else if($num<1000000000)
      {
        $result=NumToWords($num/1000000)." juta ".NumToWords($num % 1000000);
      }
      else if($num<1000000000000)
      {
        $result=NumToWords($num/1000000000)." milyar ".NumToWords(fmod($num,1000000000));
      }
      else if($num<1000000000000000)
      {
        $result=NumToWords($num/1000000000000)." trilyun ".NumToWords(fmod($num,1000000000000));
      }
      return $result;
    }

    function amounts($num,$style=4)
    {
      $result='';
      if($num<0)
        $result='minus '.trim(NumToWords($num));
      else
        $result=trim(NumToWords($num));

      switch($style)
      {
        case 1:$result=strtoupper($result);break;
        case 2:$result=strtolower($result);break;
        case 3:$result=ucwords($result);break;
        case 4:$result=ucfirst($result);break;
      }
      return $result;
    }

    function get_extension($param)
    {
      $x=explode('.',$param);
      return end($x);
    }

    function get_mean($number)
    {
      $n=0;
      $tot=0;
      $mean=0;
      for($i=0;$i<count($number);$i++)
      {
        if(is_numeric($number[$i])==TRUE)
        {
          $n++;
          $tot+=$number[$i];
        }
      }
      $mean=($n!=0?$tot/$n:0);
      return $mean;
    }

    function week_in_month($date, $rollover='sunday')
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $weeks = 1;

        for ($i = 1; $i <= $elapsed; $i++)
        {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if($day == strtolower($rollover))  $weeks ++;
        }

        return $weeks;
    }

    function upload_image($path,$uptmplocation,$uptype,$upname,$upsize,$uperror,$max=500000,$file_rep='')
    {
        /*
            error description
            1=>format error
            2=>uploading error        
        */

        $tmpLocation=$uptmplocation;
        $error='0';
        $gambar=$file_rep;
        if(!empty($tmpLocation))
        {
            $extAllowed=array('jpg','jpeg','png','xpng','gif');
            $temp=explode('.',$upname);      
            if(($uptype=='image/jpg'
             || $uptype=='image/jpeg'            
             || $uptype=='image/pjpeg'
             || $uptype=='image/x-png'
             || $uptype=='image/png'
             || $uptype=='image/gif')
             && in_array(strtolower(end($temp)),$extAllowed) && ($upsize<$max))
            {
                if($uperror>0)
                {
                  $status=false;
                  $error="2";
                }
                else
                {               
                  
                  if($file_rep!='')
                  {
                    if(file_exists($path.'/'.$file_rep)==TRUE)
                    {
                      unlink($path.'/'.$file_rep);
                    }
                  }
                  
                  move_uploaded_file($tmpLocation,$path.'/'.$upname);
                  $status=true;
                }
            }
            else
            {
                $status=false;
                $error="1";            
            }
        }
        else
        {
            $gambar=($file_rep!=''?$file_rep:'');     
            $status=true;
        }
        $result[0]=$status;     
        $result[1]=$error;
        return $result;
    }   

    function delete_image($name,$path)
    {
        if($name!='')
        {
          if(file_exists($path.'/'.$name)==TRUE)
          {
              unlink($path.'/'.$name);
          }
        }
    }

    function generatePassword($size=8){
        $p = openssl_random_pseudo_bytes(ceil($size*0.67), $crypto_strong);
        $p = str_replace('=', '', base64_encode($p));
        $p = strtr($p, '+/', '^*');
        return substr($p, 0, $size);      
    }

  
  //end of file mix_helper.php
