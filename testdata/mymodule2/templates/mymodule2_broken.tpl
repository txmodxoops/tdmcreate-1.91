<{include file='db:mymodule2_header.tpl'}>
<table class='table table-bordered'>
	<thead class='outer'>
		<tr class='head'>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_ID}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_TEXT}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_TEXTAREA}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_DHTML}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_CHECKBOX}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_YESNO}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_SELECTBOX}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_USER}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_COLOR}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_IMAGELIST}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_URLFILE}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_UPLIMAGE}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_UPLFILE}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_TEXTDATESELECT}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_SELECTFILE}></th>
			<th class="center"><{$smarty.const._MA_MYMODULE2_TF_STATUS}></th>
		</tr>
	</thead>
	<tbody>
		<{foreach item=testfield from=$testfields}>
		<tr class='<{cycle values="odd, even"}>'>
			<td class='center'><{$testfield.id}></td>
			<td class='center'><{$testfield.text}></td>
			<td class='center'><{$testfield.textarea}></td>
			<td class='center'><{$testfield.dhtml}></td>
			<td class='center'><{$testfield.checkbox}></td>
			<td class='center'><{$testfield.yesno}></td>
			<td class='center'><{$testfield.selectbox}></td>
			<td class='center'><{$testfield.user}></td>
			<td class='center'><span class='#<{$testfield.color}>'><{$mymodule2_upload_url}>/images/testfields/<{$testfield.color}></span>
</td>
			<td class='center'><img src='<{xoModuleIcons32}><{$testfield.imagelist}>' alt='testfields' /></td>
			<td class='center'><{$testfield.urlfile}></td>
			<td class='center'><img src='<{$mymodule2_upload_url}>/images/testfields/<{$testfield.uplimage}>' alt='testfields' /></td>
			<td class='center'><{$testfield.uplfile}></td>
			<td class='center'><{$testfield.textdateselect}></td>
			<td class='center'><{$testfield.selectfile}></td>
			<td class='center'><{$testfield.status}></td>
		</tr>
		<{/foreach}>
	</tbody>
</table>
<{include file='db:mymodule2_footer.tpl'}>
