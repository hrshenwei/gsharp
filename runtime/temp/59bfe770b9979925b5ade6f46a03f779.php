<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"E:\SWProject\PHP\gsharp.cn\public/../application/admin\view\MgrActionList\Edit.html";i:1463469550;}*/ ?>
<form name="[form_id]" id="[form_id]" action="<?php echo url('Edit'); ?>" method="post" novalidate="novalidate">
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
						<?php if(is_array($metaStatusList)): $i = 0; $__LIST__ = $metaStatusList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$metaStatusVal): $mod = ($i % 2 );++$i;?>
                			<option value="<?php echo $metaStatusVal['Id']; ?>"><?php echo $metaStatusVal['Value']; ?></option>
                		<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
                </td>
            </tr>
        </tbody>
	</table>
</form>