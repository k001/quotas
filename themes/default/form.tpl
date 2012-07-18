<table width="100%" border="0" cellspacing="0" cellpadding="4" align="center">
    <tr class="letra12">
        {if $mode eq 'input'}
        <td align="left">
            <input class="button" type="submit" name="save_new" value="{$SAVE}">&nbsp;&nbsp;
            <input class="button" type="submit" name="cancel" value="{$CANCEL}">
        </td>
        {elseif $mode eq 'view'}
        <td align="left">
            <input class="button" type="submit" name="cancel" value="{$CANCEL}">
        </td>
        {elseif $mode eq 'edit'}
        <td align="left">
            <input class="button" type="submit" name="submit_apply_changes" value="{$APPLY_CHANGES}">
            <input class="button" type="submit" name="cancel" value="{$CANCEL}">
        </td>
        {/if}
        <td align="right" nowrap><span class="letra12"><span  class="required">*</span> {$REQUIRED_FIELD}</span></td>
    </tr>
</table>
<table class="tabForm" style="font-size: 16px;" width="100%" >
	<tr class="letra12">
		<td align="left">Seleccione formulario:</td>
		<td align="left">
                <select align="center" name="customer_id">
	                 <option value='null'>-- Seleccionar --</option>
                    {html_options options=$cust_options selected=$customer_id}
                </select>
        </td>
	</tr>
	<tr class="letra12">
		<td align="left"><b>EDAD</b></td>
		<td align="left"><b>Hombres</b></td>
		<td align="left"><b>Mujeres</b></td>
	</tr>
    <tr class="letra12">
        <td align="left"><b>{$1h.LABEL} a&ntilde;os<span  class="required">*</span></b></td>
        <td align="left">{$1h.INPUT}</td>
        <td align="left">{$1m.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>{$2h.LABEL} a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$2h.INPUT}</td>
        <td align="left">{$2m.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>{$3h.LABEL} a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$3h.INPUT}</td>
        <td align="left">{$3m.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>{$4h.LABEL} a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$4h.INPUT}</td>
        <td align="left">{$4m.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>{$5h.LABEL} <span  class="required">*</span></b></td>
        <td align="left">{$5h.INPUT}</td>
        <td align="left">{$5m.INPUT}</td>
    </tr>
</table>
<input class="button" type="hidden" name="id" value="{$ID}" />