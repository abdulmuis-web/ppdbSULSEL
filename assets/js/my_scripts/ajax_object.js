    /**
     *
     * @author        HBS
     * @link          -
     * @created_date  2016-01-20
     */
     
    var ajax_object={
        n_req:1,
        req_type:'',
        plugin_datatable:new Array(false), 
        plugin_datepicker:new Array(false), 
        plugin_timepicker:new Array(false), 
        plugin_maskedinput:new Array(false),
        plugin_select:new Array(false),
        plugin_icheckbox:new Array(false),
        plugin_formwizard:new Array(false),        
        wizard_validation_id:new Array(''),
        masked_id:new Array(['']),
        masked_rules:new Array(['']),
        data_ajax:new Array(''),
        id_input:'',input_ajax:'',loading:'',content_:'',data_content:'',data_loading:'',close_modal:'',url:'',form_:'',dataTable_id:'',form_id:'',status_pnotify:true,

        /**
            mengembalikan semua nilai variabel object ke kondisi default
        */
        reset_object:function(){
            this.n_req=1;
            this.req_type='';
            this.plugin_datatable=new Array(false);
            this.plugin_datepicker=new Array(false);
            this.plugin_timepicker=new Array(false);
            this.plugin_maskedinput=new Array(false);
            this.plugin_select=new Array(false);            
            this.plugin_icheckbox=new Array(false);
            this.plugin_formwizard=new Array(false);            
            this.wizard_validation_id=new Array('');
            this.masked_id=new Array(['']);
            this.masked_rules=new Array(['']);
            this.data_ajax=new Array('');
            this.id_input='';this.input_ajax='';
            this.loading='';this.content_='';this.data_content='';
            this.data_loading='';this.close_modal='';this.url='';this.form_='';
            this.dataTable_id='';this.form_id='';status_pnotify=true;

            return this;
        },

        set_n_req:function(n){
            this.n_req=n;
            return this;
        },

        /**
            @result : array dari nilai yang diberikan melalui parameter val
        */
        set_value:function(val)
        {                   
            var result = new Array();
            if(typeof(val)=='object')
            {
                for(i=0;i<val.length;i++)
                {
                    result[i]=val[i];
                }            
            }
            else
            {
                result[0]=val;                
            }
                
            return result;
        },

        /* activation jquery plugin function */
        disable_pnotify:function()
        {
            this.status_pnotify=false;            
            return this;
        },

        enable_pnotify:function(){
            this.status_pnotify=true;
            return this;
        },

        set_plugin_datatable:function(pt)
        {
            this.plugin_datatable='';
            this.plugin_datatable=this.set_value(pt);
            return this;
        },

        set_plugin_datepicker:function(dp)
        {
            this.plugin_datepicker='';
            this.plugin_datepicker=this.set_value(dp);
            return this;
        },

        set_plugin_timepicker:function(tp)
        {
            this.plugin_timepicker='';
            this.plugin_timepicker=this.set_value(tp);
            return this;
        },        

        set_plugin_maskedinput:function(mi)
        {
            this.plugin_maskedinput='';
            this.plugin_maskedinput=this.set_value(mi);
            return this;
        },

        set_plugin_select:function(s)
        {
            this.plugin_select='';
            this.plugin_select=this.set_value(s);
            return this;
        },

        set_plugin_icheckbox:function(ic)
        {
            this.plugin_icheckbox='';
            this.plugin_icheckbox=this.set_value(ic);
            return this;
        },

        set_plugin_formwizard:function(fw)
        {
            this.plugin_formwizard='';
            this.plugin_formwizard=this.set_value(fw);
            return this;
        },
        set_wizard_validation_id:function(wi)
        {
            this.wizard_validation_id='';
            this.wizard_validation_id=this.set_value(wi);
            return this;
        },
        set_masked_rules:function(mr)
        {
            this.masked_rules='';
            this.masked_rules=this.set_value(mr);
            return this;
        },
        set_masked_id:function(mi)
        {
            this.masked_id='';
            this.masked_id=this.set_value(mi);
            return this;
        },
        /* EOF activation jquery plugin function */

        set_url:function(url){
            this.url='';
            this.url=this.set_value(url);
            return this;
        },

        set_id_input:function(id){            
            this.id_input=(id!=''?this.set_value(id):'');
            return this;
        },

        set_table_id:function(id){
            this.dataTable_id='';
            this.dataTable_id=this.set_value(id);
            
            return this;
        },

        set_loading:function(ml){
            this.loading='';
            this.loading=this.set_value(ml);
            return this;
        },

        set_content:function(mc){
            this.content_='';
            this.content_=this.set_value(mc);
            return this;
        },

        set_form:function(form){
            this.form_='';
            this.form_=form;
            return this;
        },

        set_close_modal:function(cm){
            this.close_modal='';
            this.close_modal=cm;
            return this;
        },

        set_form_id:function(fi){
            this.form_id='';
            this.form_id=fi;
            return this;
        },

        set_input_ajax:function(id_input){            
            if(typeof(this.id_input)=='object')
            {                
                this.input_ajax=new Array();
                for(i=0;i<this.id_input.length;i++)
                {
                    this.input_ajax[i]=$('#'+this.id_input[i]+' > input#'+id_input);
                }
            }
            return this;
        },

        /**
            @result : nilai dari inputan ajax dengan format nama=nilai
        */
        set_data_ajax:function(data){
            var data_ajax=new Array('');

            var dt='';
            var x=false;
            if(this.input_ajax!='')
            {
                for(i=0;i<this.input_ajax.length;i++)
                {                        
                    x=false;
                    that = this;
                    this.input_ajax[i].each(function(){                
                        if(x==true)
                            dt+='&';

                        dt+=$(this).attr('name')+'='+$(this).val();                                                
                        
                        x=true;                
                    });                    
                    data_ajax[i]=dt;

                }                
            }

            if(typeof(data)=='object')
            {
                x=false;
                dt='';
                ex='';
                for(i=0;i<data.length;i++)
                {
                    if(x==true)
                        dt+='&';
                    
                    ex=data[i].split('=');
                    
                    dt+=(ex.length==2?ex[0]+'='+ex[1]:ex[0]+'='+ex[0]);
                    x=true;
                }
                data_ajax[0]+=(data_ajax[0]!=''?'&':'')+dt;
            }
            this.data_ajax=data_ajax;
            return this;
        },
        
        setup_jquery_plugin:function(i){

            //data-table
            if(this.plugin_datatable[i])
            {     
                var dataTable_id=(typeof(this.dataTable_id[i])=='undefined'?'data-table-jq':this.dataTable_id[i]);

                oTable = $('#'+dataTable_id).dataTable({
                            "oLanguage": {
                            "sSearch": "Search :"
                            },
                            "aoColumnDefs": [
                                {
                                    'bSortable': false,
                                    'aTargets': [0]
                                } //disables sorting for column one
                            ],
                            'iDisplayLength': 10,
                            "sPaginationType": "full_numbers"
                        });
                
            }
            //END data-table

            //input-mask
            if(this.plugin_maskedinput[i])
            {                
                for(j=0;j<this.masked_id[i].length;j++)
                {                    
                    $("#"+this.masked_id[i][j]).mask(this.masked_rules[i][j]);
                }
            }
            //END input-mask

            //Bootstrap timepicker
            if(this.plugin_timepicker[i])
            {                
                var feTimepicker = function(){
                    // Default timepicker
                    if($(".timepicker").length > 0)
                        $('.timepicker').timepicker();
                    
                    // 24 hours mode timepicker
                    if($(".timepicker24").length > 0)
                        $(".timepicker24").timepicker({minuteStep: 5,showSeconds: true,showMeridian: false});
                    
                }
            }
            //END Bootstrap timepicker

            //Bootstrap datepicker
            if(this.plugin_datepicker[i])
            {                            
                if($(".datepicker").length > 0){
                    $(".datepicker").datepicker({format: 'dd-mm-yyyy'});
                    $("#dp-2,#dp-3,#dp-4").datepicker(); // Sample
                }                
            }                         
            // END Bootstrap datepicker

            //Bootstrap select
            if(this.plugin_select[i])
            {                
                if($(".select").length > 0){
                    $(".select").selectpicker();
                    
                    $(".select").on("change", function(){
                        if($(this).val() == "" || null === $(this).val()){
                            if(!$(this).attr("multiple"))
                                $(this).val("").find("option").removeAttr("selected").prop("selected",false);
                        }else{
                            $(this).find("option[value="+$(this).val()+"]").attr("selected",true);
                        }
                    });
                }                
            }
            //END Bootstrap select

            //iCheckbox and iRadion - custom elements
            if(this.plugin_icheckbox[i])
            {                
                if($(".icheckbox").length > 0){
                     $(".icheckbox,.iradio").iCheck({checkboxClass: 'icheckbox_minimal-grey',radioClass: 'iradio_minimal-grey'});
                }                                            
            }
            // END iCheckbox

            // Smart Wizard
            if(this.plugin_formwizard[i])
            {

                if($(".wizard").length > 0)
                {
                
                    //Check count of steps in each wizard
                    $(".wizard > ul").each(function(){
                        $(this).addClass("steps_"+$(this).children("li").length);
                    });//end
                    
                    // This par of code used for example
                    if($(this.wizard_validation_id[i]).length > 0)
                    {                        
                        var validator = $(this.wizard_validation_id[i]).validate({
                                            rules: {                                                
                                                hidden_element: {
                                                    required: true                                                    
                                                }
                                            },
                                            messages: {                
                                                hidden_element: {
                                                    required: "test"
                                                }
                                            }
                                        });
                            
                    }// End of example
                    
                    $(".wizard").smartWizard({                        
                        // This part of code can be removed FROM
                        onLeaveStep: function(obj){
                            var wizard = obj.parents(".wizard");

                            if(wizard.hasClass("wizard-validation"))
                            {
                                
                                var valid = true;
                                
                                $('input,textarea,select',$(obj.attr("href"))).each(function(i,v){
                                    valid = validator.element(v) && valid;
                                });
                                                            
                                if(!valid){
                                    wizard.find(".stepContainer").removeAttr("style");
                                    validator.focusInvalid();                                
                                    return false;
                                }         
                                
                            }    
                            
                            return true;
                        },// <-- TO
                        
                        //This is important part of wizard init
                        onShowStep: function(obj){                        
                            var wizard = obj.parents(".wizard");

                            if(wizard.hasClass("show-submit")){
                            
                                var step_num = obj.attr('rel');
                                var step_max = obj.parents(".anchor").find("li").length;

                                if(step_num == step_max){                             
                                    obj.parents(".wizard").find(".actionBar .btn-primary").css("display","block");
                                }                         
                            }
                            return true;                         
                        }//End
                    });
                }  
            }
            // End Smart Wizard
        },

        /**
            menerima request dari client kemudian dikirim ke server dan
            menerima respon server untuk diberikan ke client pada bagian 
            halaman website tertentu 
            (request ini tidak memuat ulang seluruh halaman website)
        */
        request_ajax:function(i,t){ //t=0,t=1
            that=this;
            i = (typeof(i)=='undefined'?0:i);
            t = (typeof(t)=='undefined'?1:t);
            if(i<this.n_req)
            {
                $.ajax({
                    type:'POST',
                    url:this.url[i],
                    data:this.data_ajax[i],
                    beforeSend:function(){
                        $(that.content_[i]).hide();
                        if(that.loading[i]!='')
                            $(that.loading[i]).show();
                    },
                    complete:function(){
                        if(that.loading[i]!='')
                            $(that.loading[i]).hide();

                        that.request_ajax(i+1);
                    },
                    success:function(data){
                        $(that.content_[i]).show();
                        if(t==1)
                            $(that.content_[i]).html(data);
                            
                        else
                        {                            
                            $(that.content_[i]).val(data);

                        }

                        that.setup_jquery_plugin(i);
                    }
                });
            }
        },

        /**
            menerima request dari client kemudian dikirim ke server dan
            menerima respon server untuk diberikan ke client pada bagian 
            halaman website tertentu 
            (request ini tidak memuat ulang seluruh halaman website)
        */
        
        update_ajax:function(act_lbl,i){
            that=this;
            i = (typeof(i)=='undefined'?0:i);
            $.ajax({
                type:'POST',
                url:this.url[0],
                data:this.data_ajax[0],
                beforeSend:function(){ 
                    if(that.loading[0]!='')
                        $(that.loading[0]).show();
                },
                complete:function(){                
                    if(that.loading[0]!='')
                        $(that.loading[0]).hide();
                },
                success:function(data){
                    var content_box,title_box,color_box,icon_box;
                                        

                    if(data!='failed')
                    {                        

                        x_data = data.split('|$*{()}*$|');

                        for(j=0;j<=i;j++)
                        {
                            if(that.content_[j]!='')
                            {                                
                                //show data                                
                                $(that.content_[j]).html(x_data[j]);

                                that.setup_jquery_plugin(j);
                            }
                        }

                        content_box = act_lbl;
                        title_box = 'Berhasil';
                        color_box = '659265';
                        icon_box = "fa-check";
                    }
                    else
                    {
                        content_box = act_lbl;
                        title_box = 'Gagal';
                        color_box = 'C46A69';
                        icon_box = "fa-times";
                    }
                    
                    if(that.status_pnotify==true)
                    {
                        /*
                        * SmartAlerts
                        */
                        $.smallBox({
                            title : title_box,
                            content : content_box,
                            color : "#"+color_box,
                            iconSmall : "fa "+icon_box+" fa-2x fadeInRight animated",
                            timeout : 5000
                        });
                        
                        // noty({text: text, layout: 'topRight', type: type,timeout:5000})
                    }

                }
            });
            
        },

        submit_ajax:function(act_lbl,i){
            that=this;
            i = (typeof(i)=='undefined'?0:i);
            $.ajax({
                type:'POST',
                url:this.form_.attr('action'),
                data:this.form_.serialize(),
                beforeSend:function(){
                    
                    if(that.loading[i]!='')
                    {                        
                        $(that.loading[i]).show();
                    }
                    // if(that.content_[i]!='')
                    // {                                                    
                    //     $(that.content_[i]).hide();
                        
                    // }
                },
                complete:function(){
                    
                    if(that.close_modal!='')
                    {                        
                        $(that.close_modal).click();
                    }
                    if(that.loading[0]!='')
                        $(that.loading[0]).hide();
                    
                },
                success:function(data)
                {
                    
                    var content_box,title_box,color_box,icon_box;
                    
                    error=/ERROR/;
                                
                    if(!data.match(error))
                    {
                        
                        x_data = data.split('|$*{()}*$|');

                        for(j=0;j<=i;j++)
                        {
                            if(that.content_[j]!='')
                            {
                                $(that.content_[j]).show();
                                //show data                                
                                $(that.content_[j]).html(x_data[j]);

                                that.setup_jquery_plugin(j);
                            }
                        }

                        content_box = act_lbl;
                        title_box = 'Berhasil';
                        color_box = '659265';
                        icon_box = "fa-check";
                    }
                    else
                    {
                        
                        x = data.split(':');
                        content_box = x[1].trim();
                        title_box = 'Gagal';
                        color_box = 'C46A69';
                        icon_box = "fa-times";
                    }
                    

                    if(that.status_pnotify==true)
                    {                    
                        /*
                        * SmartAlerts
                        */                        

                        $.smallBox({
                            title : title_box,
                            content : content_box,
                            color : "#"+color_box,
                            iconSmall : "fa "+icon_box+" fa-2x fadeInRight animated",
                            timeout : 5000
                        });
                        
                        // noty({text: text, layout: 'topRight', type: type,timeout:5000})
                    }
                }
            });
        }        
        
    }