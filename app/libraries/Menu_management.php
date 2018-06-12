<?php
		
	class menu_management{


		public function __construct()
		{			
		}

		function parseMenuTree($tree,$root = 0)
		{
		    $return = array();
		    $parent_=false;
		    $masterRoot=false;        

		    # Traverse the tree and search for direct children of the root
		    $_tree = array_column($tree,'reference');

		    foreach($tree as $key => $val) 
		    {

		        # A direct child is found
		        if($val['reference'] == $root)
		        {

		            $masterRoot=($root==0?true:false);

		            # Remove item from tree (we don't need to traverse this again)
		            unset($tree[$key]);
		            
		            $parent_=(in_array($key,$_tree)?true:false);

		            # Append the child into result array and parse its children

		            $men_content = array(
		                	'title'=>$val['title'],
		                	'url'=>($val['url']==''?'#':$val['url']),
		                	'icon'=>$val['image'],
		                	'url_target'=>$val['url_target'],
		                	'li_class'=>$val['li_class'],
		                	);

		            
		            if($val['hierarchy']=='1')
		            {
		            	$men_content['sub'] = $this->parseMenuTree($tree,$key);
		            }
		            $return[strtolower(str_replace(' ','_',$val['title']))] = $men_content;
		            
		        }
		    }

		    return empty($return) ? null : $return;
		}
		
	}
?>