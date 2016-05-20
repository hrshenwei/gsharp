<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:84:"E:\SWProject\PHP\gsharp.cn\public/../application/admin\view\MgrActionList\index.html";i:1463473304;s:78:"E:\SWProject\PHP\gsharp.cn\public/../application/admin\view\Layout\layout.html";i:1463709134;s:85:"E:\SWProject\PHP\gsharp.cn\public/../application/admin\view\MgrActionList\Create.html";i:1463469487;s:83:"E:\SWProject\PHP\gsharp.cn\public/../application/admin\view\MgrActionList\Edit.html";i:1463470262;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $description; ?>" />
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge"/>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"/>
    <link rel="apple-touch-icon" href="" />
    <link href="__ROOT__static/css/admin-default.css" rel="stylesheet" type="text/css" />
    <link href="__ROOT__static/jquery-ui-1.11.4/jquery-ui.min.css" rel="Stylesheet" type="text/css" />
    <link href="__ROOT__static/jQuery-Timepicker-Addon-master/src/jquery-ui-timepicker-addon.css" rel="Stylesheet" type="text/css" />
    <link href="__ROOT__static/DataTables-1.10.11/media/css/demo_table_jui.css" rel="Stylesheet" type="text/css" />
    
    <script type="text/javascript" src="__ROOT__static/js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="__ROOT__static/jquery_jeditable-master/jquery.jeditable.js"></script>
    <script type="text/javascript" src="__ROOT__static/js/ChineseCalendar.js"></script>
    <script type="text/javascript" src="__ROOT__static/js/jquery.ajaxHelper.js"></script>
    <script type="text/javascript" src="__ROOT__static/js/mydialog.js"></script>
    <!-- 
    <script type="text/javascript" src="__ROOT__static/js/jquery.ui.datepicker-zh-CN.min.js"></script>
    -->
    <script type="text/javascript" src="__ROOT__static/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="__ROOT__static/jQuery-Timepicker-Addon-master/src/jquery-ui-sliderAccess.js"></script>
    <script type="text/javascript" src="__ROOT__static/jQuery-Timepicker-Addon-master/src/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="__ROOT__static/jQuery-Timepicker-Addon-master/src/i18n/jquery-ui-timepicker-zh-CN.js"></script>
    <script type="text/javascript" src="__ROOT__static/js/DateFormat.js"></script>
    <script type="text/javascript" src="__ROOT__static/DataTables-1.10.11/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="__ROOT__static/jquery-validation-1.15.0/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
	    $.validator.setDefaults({
	        onkeyup: function () { return true; }
	    });
    </script>
	<script type="text/javascript" src="__ROOT__static/jquery-validation-1.15.0/dist/localization/messages_zh.min.js"></script>
	<script type="text/javascript" src="__ROOT__static/js/validate.js"></script>
    
    <script type="text/javascript"> 
    	$(function () {
            //显示首页导航菜单时间
            getTime();
            var lunar = ChineseCalendar.solar2lunar();
            $('#my_lunarYear').html(lunar.IMonthCn+lunar.IDayCn+'；'+lunar.gzYear+'年'+lunar.gzMonth+'月'+lunar.gzDay+'日（'+lunar.Animal+'年）');
            
            var url = window.location.href.replace('http://', '');
            changeNavStyle(url);
            /*
            $.ajaxGetJSON('<?php echo url("/admin/Index/getUserInfoJson"); ?>' + '?' + Math.random(), null,
            function (data, textStatus, jqXHR) {
                if (data != undefined) {
                	$('#my_adminUser').html(data.userAccount);
                	$('#my_dateDay').html(data.dateDay);
                } else {
                    dialogAlert({
                        bSuccess: false,
                        message: '加载登陆用户信息失败!'
                    });
                }
            });
            */
        });
    </script>
    <script type="text/javascript">
        function getTime() {
            var curDate = new DateFormat().format(new Date(), 'HH:mm:ss');
            $('#my_time').html(curDate);
            setTimeout('getTime()', 1000);
        }
    </script>
    <script type="text/javascript">
        function ClickMainMenu(mid) {
            var menu = '#menu_' + mid;
            var submenu = '#submenus_' + mid;
            $('ul[class="leftnavlist"]').hide(500);
            $('p[class="leftnavtit"] > a').addClass('on');
            if ($(submenu).is(":hidden")) {
                $(menu + ' > a').removeClass('on');
                $(submenu).show(500);
            } else {
                $(menu + ' > a').addClass('on');
                $(submenu).hide(500);
            }
        };

        //var defaultOpenMenuName = '@ViewBag.DefaultOpenMenuName';

        function changeNavStyle(url) {
            var suburlpos = url.indexOf('?');
            var suburl = url;
            if (suburlpos > 0) {
                suburl = url.substr(0, suburlpos);
            }
            suburlpos = url.indexOf('/admin/');
            if (suburlpos > 0) {
            	suburlpos = suburlpos;// + '/admin/'.length;
                suburl = suburl.substr(suburlpos, suburl.length - suburlpos);
            }

            var id = $('ul > li[url="' + suburl + '"]').attr('id');
            var title = '';
            if (id != undefined) {
                var temp = id.split('_');
                var menu = '#menu_' + temp[1];
                var submenu = '#submenus_' + temp[1];
                var submenuItem = '#submenu_' + temp[1] + '_' + temp[2];
                if ($(menu + ' > a').attr('class') == 'on') {
                    $('ul[class="leftnavlist"]').hide(500);
                    $('p[class="leftnavtit"] > a').addClass('on');
                    $(menu + ' > a').removeClass('on');
                    $(submenu).show(500);
                }
                $('ul.leftnavlist > li').removeClass('on');
                $(submenuItem).addClass('on');
                var uptitle = $(menu + ' > a > span').html();
                title = ' &gt; ' + $(submenuItem + '>a').html();
                $('.breadnav').html('您现在的位置是：<a href="<?php echo url('/admin/Index/index'); ?>" target="_self">首页</a>' + ' &gt; ' + uptitle + title);
            }
        };
    </script>
</head>
<body>
	<!--页头-->
	<div class="headbox">
	    <div class="headcont">
	        <h1><a href="/" title="" hidefocus="true"></a></h1>
	        <span class="telimg"><!-- <img src="#" alt=""/> --></span>
	    </div>
        <p class="bookimg"><!-- <img src="#" alt=""/> --></p>
	</div>
    <div class="timebar">
        <p class="timemate">欢迎您：<span id="my_adminUser">加载中...</span>，今天是<span id="my_dateDay">加载中...</span> ，农历<span id="my_lunarYear"></span>，时间<span id="my_time">加载中...</span></p>
        <p class="exitmate"><a href="<?php echo url('Logout'); ?>" title="">退出登录</a></p>
    </div>
	<!--页头结束-->
	
    <!--左侧导航-->
    <div class="leftnavbox">
    	<?php if(is_array($arrayMenu) || $arrayMenu instanceof \think\Collection): if( count($arrayMenu)==0 ) : echo "" ;else: foreach($arrayMenu as $key=>$menu): ?>
    		<p class="leftnavtit" id="menu_<?php echo $menu['menuId']; ?>" name="<?php echo $menu['menuCaption']; ?>">
                <a href="javascript:ClickMainMenu(<?php echo $menu['menuId']; ?>);" class="on"><span><?php echo $menu['menuCaption']; ?></span></a>
            </p>
            <?php if(count($menu['childMenu']) > 0): ?>
            	<ul class="leftnavlist" id="submenus_<?php echo $menu['menuId']; ?>" style="display: none;">
            	<?php if(is_array($menu['childMenu']) || $menu['childMenu'] instanceof \think\Collection): if( count($menu['childMenu'])==0 ) : echo "" ;else: foreach($menu['childMenu'] as $key=>$SubMenu): ?>
           			<li id="submenu_<?php echo $menu['menuId']; ?>_<?php echo $SubMenu['menuId']; ?>" url="<?php echo $SubMenu['menuUrl']; ?>" style="cursor: pointer;"><a href="<?php echo $SubMenu['menuUrl']; ?>" title="<?php echo $SubMenu['menuCaption']; ?>"><?php echo $SubMenu['menuCaption']; ?></a></li>
            	<?php endforeach; endif; else: echo "" ;endif; ?>
            	</ul>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </div>
	<!--左侧导航结束-->
	
    <div class="contbox">
        <!--导航-->
        <div class="breadnav">您现在的位置是：<a target="_self" href="<?php echo url('/admin/Index/index'); ?>">首页</a></div>
        <div class="rContent">
            <script type="text/javascript">
	var oTbMgrAction;
	var anOpen = [];
	var metaStatusArr = <?php echo $metaStatusJson; ?>;
	$(function () {
		oTbMgrAction = $('#tbMgrAction').dataTable({
            'bProcessing': false,
            'bServerSide': true,
            'bPaginate': true,
            'iDisplayLength': iDefaultDisplayLength,
            'bJQueryUI': true,
            'sDom': '<"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"lp>rt<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"ip>',
            'bSort': false,
            'bStateSave': false,
            'sAjaxSource': '<?php echo url("pageIndex"); ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                $.ajaxGetJSON(sSource, aoData, fnCallback);
            },
            'sPaginationType': 'full_numbers',
            'oLanguage': {
                'sUrl': '__ROOT__static/DataTables-1.10.11/media/jquery.dataTable.cn.txt'
            },
            'aoColumns': [
                {
                	'mDataProp': 'actionName', 
                	'sName': 'actionName',
                	'fnCreatedCell': function(nTd, sData, oData, iRow, iCol){
                		$(nTd).addClass('actionName').attr('id', 'actionName_' + sData + '_' + oData.actionId);
                	}
                },
                { 
                	'mDataProp': 'actionCaption', 
                	'sName': 'actionCaption',
                	'fnCreatedCell': function(nTd, sData, oData, iRow, iCol){
                		$(nTd).addClass('actionCaption').attr('id', 'actionCaption_' + sData + '_' + oData.actionId);
                	}
                },
                { 
                	'mDataProp': 'createTime', 
                	'sName': 'createTime'
                },
                { 
                	'mDataProp': 'lastTime', 
                	'sName': 'lastTime'
                },
                { 
                	'mDataProp': 'metaStatus', 
                	'sName': 'metaStatus',
                	'fnCreatedCell': function(nTd, sData, oData, iRow, iCol){
                		$(nTd).addClass('metaStatus').attr('id', 'metaStatus_' + oData.metaStatus + '_' + oData.actionId);
                	},
                	'mRender': function(data, type, full){
                		return metaStatusArr[data];
                	}
                },
                {
                    'sTitle': '操作',
                    'sClass': 'control',
                    'bSortable': false,
                    'mData': 'actionId',
                    'mRender': function (data, type, full) {
                    	var reStr = '<a href="javascript:void(0)" name="EditMgrAction" onclick="EditMgrActionClick(\'' + data + '\')">编辑</a>&nbsp;'
                    	+ '<a href="javascript:void(0)" name="DeleteMgrAction" onclick="DeleteClick(\'' + data + '\',\'' + full['actionName'] + '\')">删除</a>';
                        return reStr;
                    }
                }
            ],
            'fnDrawCallback': function (oSettings) {
            	$('#tbMgrAction tbody td.actionName').editable('<?php echo url("editMgrAction"); ?>', {
                    type: 'text',
                    event: 'dblclick',
                    //cancel    : '取消',
                    //submit    : '确定',
                    onblur: 'submit',
                    indicator: '保存中...',
                    tooltip: '双击编辑',
                    onsubmit: function (settings, original) {
                    	$('form', original).validate({
                    		rules: {
                                value: {
                                    required: true,
                                    remote: {
                						url: '<?php echo url("checkMenuNameExist"); ?>',
                						data: {
                							actionName: function(){
                								var actionNameVal = $('form input', original).val();
                								return actionNameVal;
                							},
                							actionId: function(){ 
                								var actionIdVal = $(original).attr('id').split('_')[2];
                								return actionIdVal; 
                							}
                						}
                					}
                                }
                            },
                            messages: {
                                value: {
                                    required: '*',
                                    remote: '该菜单名称已存在'
                                }
                            }
                        });
                        return $('form', original).valid();
                    }
                });
            	$('#tbMgrAction tbody td.actionCaption').editable('<?php echo url("editMgrAction"); ?>', {
                    type: 'text',
                    event: 'dblclick',
                    //cancel    : '取消',
                    //submit    : '确定',
                    onblur: 'submit',
                    indicator: '保存中...',
                    tooltip: '双击编辑',
                    onsubmit: function (settings, original) {
                        $('form', original).validate({
                            rules: {
                                value: {
                                    required: true
                                }
                            },
                            messages: {
                                value: {
                                    required: '*'
                                }
                            }
                        });
                        return $('form', original).valid();
                    }
                });
                $('#tbMgrAction tbody td.metaStatus').editable('<?php echo url("editSelectMgrAction"); ?>', {
                    onblur: 'submit',
                    indicator: '保存中...',
                    tooltip: '双击选择',
                    type: 'select',
                    event: 'dblclick',
                    data: metaStatusArr,
                    ajaxoptions: {
                    	dataType: 'json'
                    }
                });
            }
        });
		
		$('#bSearch', $('#divMgrActionSearch')).click(function () {
			var oSettings = oTbMgrAction.fnSettings();
			
            oSettings.aoPreSearchCols[0].sSearch = $('#actionName', $('#divMgrActionSearch')).val();
            oSettings.aoPreSearchCols[0].bRegex = false;
            oSettings.aoPreSearchCols[0].bSmart = true;
            
            oSettings.aoPreSearchCols[1].sSearch = $('#metaStatus', $('#divMgrActionSearch')).val();
            oSettings.aoPreSearchCols[1].bRegex = false;
            oSettings.aoPreSearchCols[1].bSmart = true;

            oTbMgrAction.fnDraw();
        });
		$('#digCreateMgrAction').dialog({
            width: 560,
            bgiframe: true,
            autoOpen: false,
            modal: true,
            buttons: {
                '新增': function () {
                    CreateMgrAction($("#frm-CreateMgrAction"));
                },
                '取消': function () { $(this).dialog('close'); }
            }
        });
		
		$('#bInsert', $('#divMgrActionSearch')).click(function () {
			$('#digCreateMgrAction').dialog('open');
        });
		$('#digEditMgrAction').dialog({
            width: 560,
            bgiframe: true,
            autoOpen: false,
            modal: true,
            buttons: {
                '更新': function () {
                    EditMgrAction($("#frm-EditMgrAction"));
                },
                '取消': function () { $(this).dialog('close'); }
            }
        });
		var validatorCreateMgrAction = $('#frm-CreateMgrAction').validate({
			rules: {
				actionName: {
					required: true,
					remote: {
						url: '<?php echo url("checkActionNameExist"); ?>',
						data: {
							actionName: function(){return $('#actionName', $('#frm-CreateMgrAction')).val();}
						}
					}
				},
				actionCaption: {
					required: true
				},
				metaStatus: {
					required: true
				}
			},
			messages: {
				actionName: {
					required: '*',
					remote: '该Action名称已存在'
				},
				actionCaption: {
					required: '*'
				},
				serialNumber: {
					required: '*',
					number: '请输入数字'
				},
				metaStatus: {
					required: '*'
				}
			},
			ignore: '.ignore'
		});
		var validatorEditMgrAction = $('#frm-EditMgrAction').validate({
			rules: {
				actionName: {
					required: true,
					remote: {
						url: '<?php echo url("checkActionNameExist"); ?>',
						data: {
							actionName: function(){return $('#actionName', $('#frm-EditMgrAction')).val();},
							actionId: function(){return $('#actionId', $('#frm-EditMgrAction')).val();}
						}
					}
				},
				actionCaption: {
					required: true
				},
				metaStatus: {
					required: true
				}
			},
			messages: {
				actionName: {
					required: '*',
					remote: '该Action名称已存在'
				},
				actionCaption: {
					required: '*'
				},
				metaStatus: {
					required: '*'
				}
			},
			ignore: '.ignore'
		});
	});
</script>
<script type="text/javascript">
	function CreateMgrAction(frmObj){
		if (frmObj.valid()) {
            var MgrAction = {
            		topMgrActionId: $('#topMgrActionId', frmObj).val(),
            		actionName: $('#actionName', frmObj).val(),
            		actionCaption: $('#actionCaption', frmObj).val(),
            		metaStatus: $('#metaStatus', frmObj).val()
            };
            $.ajaxJsonPost({
                url: frmObj.attr('action'),
                params: MgrAction,
                success: CreateMgrActionCallback
            });
        }
	};
	function CreateMgrActionCallback(data){
		dialogAlert({
            bSuccess: data.bSuccess,
            message: data.message,
            open: function () {
                if (data.bSuccess) {
                	if(data.topMgrActionArr){
                		topMgrActionArr = $.extend(topMgrActionArr,data.topMgrActionArr);
                	}
                	oTbMgrAction.fnDraw(false);
                    $('#frm-CreateMgrAction')[0].reset();
                    $('#digCreateMgrAction').dialog('close');
                }
            }
        });
	};
	function EditMgrActionClick(actionId) {
        $.ajaxGetJSON($('#frm-EditMgrAction').attr('action') + '?actionId=' + actionId + '&' + Math.random(), null,
        function (data, textStatus, jqXHR) {
            if (data.actionId != undefined) {
                var frmObj = $('#frm-EditMgrAction');
                $('#actionId', frmObj).val(data.actionId);
                $('#actionName', frmObj).val(data.actionName);
                $('#actionCaption', frmObj).val(data.actionCaption);
                $('#metaStatus', frmObj).val(data.metaStatus);
                frmObj.valid();
                $('#digEditMgrAction').dialog('open');
            } else {
                dialogAlert({
                    bSuccess: false,
                    message: '此记录不存在!'
                });
            }
        });
    };
	function EditMgrAction(frmObj){
		if (frmObj.valid()) {
            var MgrAction = {
            		actionId: $('#actionId', frmObj).val(),
            		actionName: $('#actionName', frmObj).val(),
            		actionCaption: $('#actionCaption', frmObj).val(),
            		metaStatus: $('#metaStatus', frmObj).val()
            };
            $.ajaxJsonPost({
                url: frmObj.attr('action'),
                params: MgrAction,
                success: EditMgrActionCallback
            });
        }
	};
	function EditMgrActionCallback(data){
		dialogAlert({
            bSuccess: data.bSuccess,
            message: data.message,
            open: function () {
                if (data.bSuccess) {
                	oTbMgrAction.fnDraw(false);
                    $('#frm-EditMgrAction')[0].reset();
                    $('#digEditMgrAction').dialog('close');
                }
            }
        });
	};
	function DeleteClick(actionId, actionName){
		dialogConfirm({
            message: '确定要删除Action[' + actionName + ']吗？',
            Ok: function () {
            	$.ajaxJsonPost({
                    url: "<?php echo url('delete'); ?>",
                    params: {actionId : actionId},
                    success: DeleteClickCallback
                });
            }
        });
	};
	function DeleteClickCallback(data){
		dialogAlert({
            bSuccess: data.bSuccess,
            message: data.message,
            open: function () {
                if (data.bSuccess) {
                	oTbMgrAction.fnDraw(false);
                }
            },
            close: function () {
                dialogConfirmClose();
            }
        });
	}
</script>
<div id="divMgrActionSearch" class="usercont" style="width: 100%;">
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>Action名称：<input name="actionName" id="actionName" style="width: 120px;" type="text" maxlength="18" value=""></td>
			<td>
				Action状态：
				<select name="metaStatus" id="metaStatus">
					<option value="">-所有-</option>
					<?php if(is_array($metaStatusList) || $metaStatusList instanceof \think\Collection): $i = 0; $__LIST__ = $metaStatusList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$metaStatusVal): $mod = ($i % 2 );++$i;?>
              			<option value="<?php echo $metaStatusVal['Id']; ?>"><?php echo $metaStatusVal['Value']; ?></option>
               		<?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</td>
			<td>
                <input type="button" id="bSearch" value="查询" class="btn" />
                &nbsp;
                <input type="button" id="bInsert" value="新增" class="btn" />
            </td>
		</tr>
	</table>
</div>
<div class="userbox" style="width: 100%;">
	<table id="tbMgrAction" class="ex_highlight" style="width:100%">
		<colgroup>
	        <col style="width:15%" />
	        <col style="width:30%" />
	        <col style="width:15%" />
	        <col style="width:15%" />
	        <col style="width:15%" />
	        <col style="width:10%" />
	    </colgroup>
	    <thead>
	        <tr>
	            <th>Action名称</th>
	            <th>Action描述</th>
	            <th>创建时间</th>
	            <th>最后操作时间</th>
	            <th>菜单状态</th>
	            <th class="control">操作</th>
	        </tr>
	    </thead>
	    <tbody></tbody>
	</table>
</div>
<div id="digCreateMgrAction" style="display: none;width:500px;" title="新建Action">
	<form name="frm-CreateMgrAction" id="frm-CreateMgrAction" action="<?php echo url('Create'); ?>" method="post" novalidate="novalidate">
	<table id="tbCreateMgrAction" style="border: 0px currentColor; border-image: none; width: 100%;" class="usertable">
		<colgroup>
            <col style="width:20%" />
            <col style="width:80%" />
        </colgroup>
        <tbody>
        	<tr>
                <td class="editor-label">Action名称:</td>
                <td class="editor-field">
                	<input name="actionName" id="actionName" style="width: 120px;" type="text" value="">
                </td>
            <tr>
            <tr>
            	<td class="editor-label">Action描述:</td>
                <td class="editor-field">
                	<input name="actionCaption" id="actionCaption" style="width: 360px; height:200px;" type="text" value="">
                </td>
            </tr>
            <tr>
                <td class="editor-label">状态:</td>
                <td class="editor-field" colspan="3">
                	<select name="metaStatus" id="metaStatus">
						<?php if(is_array($metaStatusList) || $metaStatusList instanceof \think\Collection): $i = 0; $__LIST__ = $metaStatusList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$metaStatusVal): $mod = ($i % 2 );++$i;?>
                			<option value="<?php echo $metaStatusVal['Id']; ?>"><?php echo $metaStatusVal['Value']; ?></option>
                		<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
                </td>
            </tr>
        </tbody>
	</table>
</form>
</div>
<div id="digEditMgrAction" style="display: none;width:500px;" title="编辑Action">
	<form name="frm-EditMgrAction" id="frm-EditMgrAction" action="<?php echo url('EditData'); ?>" method="post" novalidate="novalidate">
	<table id="tbEditMgrAction" style="border: 0px currentColor; border-image: none; width: 100%;" class="usertable">
		<colgroup>
            <col style="width:20%" />
            <col style="width:80%" />
        </colgroup>
        <tbody>
        	<tr>
                <td class="editor-label">Action名称:</td>
                <td class="editor-field">
                	<input type="hidden" id="actionId" name="actionId" />
                	<input name="actionName" id="actionName" style="width: 120px;" type="text" value="">
                </td>
            <tr>
            <tr>
            	<td class="editor-label">Action描述:</td>
                <td class="editor-field">
                	<input name="actionCaption" id="actionCaption" style="width: 360px; height:200px;" type="text" value="">
                </td>
            </tr>
            <tr>
                <td class="editor-label">状态:</td>
                <td class="editor-field" colspan="3">
                	<select name="metaStatus" id="metaStatus">
						<?php if(is_array($metaStatusList) || $metaStatusList instanceof \think\Collection): $i = 0; $__LIST__ = $metaStatusList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$metaStatusVal): $mod = ($i % 2 );++$i;?>
                			<option value="<?php echo $metaStatusVal['Id']; ?>"><?php echo $metaStatusVal['Value']; ?></option>
                		<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
                </td>
            </tr>
        </tbody>
	</table>
</form>
</div>
        </div>
    </div>
</body>
</html>