// JavaScript Document
function show_time()
{
  var Digital = new Date();
  var hours = Digital.getHours();
  var minutes = Digital.getMinutes();
  var seconds = Digital.getSeconds();
  var dn = 'PM';
                       
  if(hours>=12 && minutes > 0)
  {
    hours = hours - 12;
    dn = 'PM';
  }
  else
  {    
    dn = 'AM';
  } 
  if(hours<=9)
	hours = '0'+hours;
  if(minutes <= 9)
    minutes = '0' + minutes;
  if(seconds <= 9)
    seconds = '0' + seconds;
  document.getElementById('currTime').innerHTML = hours + ':' + minutes + ':' + seconds + ' ' + dn;
  setTimeout('show_time()',1000);
}

function replaceall(str,replace,with_this)
{    
    var str_hasil ="";
    
    for(var i=0;i<str.length;i++)
    {
        if (str[i] == replace)        
            var temp = with_this;        
        else      
            var temp = str[i];
        
        str_hasil += temp;
    }
    var result = str_hasil.toString();

    return result;
}


function number_format(number,num_decimal_places,dec_separator,thousand_separator)
{
  var decimal = '000000000';  
  var number_str = number.toString();

  var negatif = (number_str.indexOf('-')>-1?'-':'');
  
  number = Math.abs(number_str);  
  number = number.toString().split(".");

  if(number.length==2)  
    numberDec=(number[1]+decimal).substring(0,num_decimal_places);
  else
    numberDec= decimal.substring(0,num_decimal_places);     
  
  mainNumber = number[0];
  var strdigit='';
  j = 0;
  for(i=(mainNumber.length-1);i>=0;i--)
  {
    if(j % 3 == 0 && j != 0)
      strdigit = thousand_separator + strdigit;

    strdigit = mainNumber.charAt(i) + strdigit;
    j++;
  }

  var result = negatif + strdigit + (num_decimal_places > 0 ? dec_separator + numberDec : '');  
    
  return result; 
}

function stringreverse(str)
{
  var strlen = str.length;
  var strrev = '';
  for(i=0;i>=5;i++)
  {
    strrev += i;//str.charAt(i);
  }
  return str;
}

function round(number,num_digits)
{
  var decimal = '000000000';

  var number_str = number.toString();
  var num_digits_str = num_digits.toString();

  var negative1 = (number_str.indexOf('-')>-1?'-':'');
  var negative2 = (num_digits_str.indexOf('-')>-1?'-':'');

  number = Math.abs(number_str);
  num_digits = Math.abs(num_digits_str);

  number = number.toString().split(".");

  if(number.length>1)
    numberDec = number[1]+decimal;
  else
    numberDec = decimal;

  mainNumber = number[0];
  
  num_len = mainNumber.length;

  result = '0';

  if(negative2!='')
  {
    if(num_len>=num_digits)
    {
      part1 = mainNumber.substr(0,num_len-num_digits);
      part2 = mainNumber.substr(num_len-num_digits,num_digits);      
            
      first = part2.substr(0,1);
      x = 0 + (parseInt(first)>=5?1:0);
      part1 = parseInt(part1) + x;

      _part1 = part1.toString();
      _part2 = '0'.repeat(num_digits);

      result = _part1+_part2;
    }
  }
  else
  {

  }

  return result;
}

function getKey(e)
{  
   if (window.event)  
   {     
     return window.event.keyCode;  
   }
   else if (e)  
   {      
     return e.which;
   }
   else  
   {      
     return null;  
   }
}

function getKeyCode(e)
{
  alert(e.which);
}

function only_number(e,object) 
{
   var key, keyChar,valid;  

   key = getKey(e);  

   valid ="0123456789.,-";
   value = object.value;

   if (key == null) return true;

   keyChar = String.fromCharCode(key).toLowerCase();


   if(valid.toLowerCase().indexOf(keyChar) != -1)
   {
      if(keyChar=='.')
      {
        if(value.toLowerCase().indexOf(keyChar) != -1)
          return false;
        else
          return true;
      }
      else if(keyChar=='-')
      {
        if(value.toLowerCase().indexOf(keyChar) != -1)
          return false;
        else
          return true;        
      }
      return true;
   }

   if ( key==0 || key==8 || key==9 || key==13 || key==27 || key==46)
     return true;

   return false;
 } 
 
function thousand_format(object)
{
   number = replaceall(object.value,',','');   
	 result = number_format(number,0,'.',',');
	 object.value = result;
}

function unangka2(objek)
{
	var i = objek.length;
	var temp = '';
	for (var j=0;j<=i;j++)
	{
		var pos = objek.charAt(j);
		if (pos == '.')
		{
			temp = temp + objek.substr(j+1,1);
			j++;
		}
		else
		{	
			temp = temp + objek.substr(j,1);
		}
	}
	
	return temp;
}

function unangka(objek)
{
	var i = objek.length;
	var temp = '';
	for (var j=0;j<=i;j++)
	{
		var pos = objek.charAt(j);
		if (pos == '.')
		{
			temp = temp + objek.substr(j+1,1);
			j++;
		}
		else{	
			if (pos == ',')
			{
				temp = temp + '.';
			}
			else temp = temp + objek.substr(j,1);
		}
	}
	return temp;
}


