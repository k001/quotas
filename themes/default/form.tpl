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
            <input class="button" type="submit" name="save_edit" value="{$EDIT}">&nbsp;&nbsp;
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
                <select align="center" name="input_formulario" id="input_formulario">
	                 <option value='null'>-- Seleccionar --</option>
                    {html_options options=$FORMULARIOS}
                </select>
        </td>
	</tr>
	<tr class="letra12">
		<td align="left"><b>EDAD</b></td>
		<td align="left"><b>Hombres</b></td>
		<td align="left"><b>Mujeres</b></td>
	</tr>
    <tr class="letra12">
        <td align="left"><b>18-24 a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$1h.INPUT}</td>
        <td align="left">{$1m.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>25-32 a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$2h.INPUT}</td>
        <td align="left">{$2m.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>33-40 a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$3h.INPUT}</td>
        <td align="left">{$3m.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>41-53 a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$4h.INPUT}</td>
        <td align="left">{$4m.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>54 y m&aacute;s: <span  class="required">*</span></b></td>
        <td align="left">{$5h.INPUT}</td>
        <td align="left">{$5m.INPUT}</td>
    </tr>

</table>
<input class="button" type="hidden" name="id" value="{$ID}" />