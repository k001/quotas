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
		<td align="left"><b>EDAD</b></td>
		<td align="left"><b>Hombres</b></td>
		<td align="left"><b>Mujeres</b></td>
	</tr>
	</tr>
    <tr class="letra12">
        <td align="left"><b>18-24 a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$diezocho.INPUT}</td>
        <td align="left">{$diezocho.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>25-32 a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$veinticinco.INPUT}</td>
        <td align="left">{$veinticinco.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>33-40 a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$treintaytres.INPUT}</td>
        <td align="left">{$treintaytres.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>41-53 a&ntilde;os: <span  class="required">*</span></b></td>
        <td align="left">{$cuarentayuno.INPUT}</td>
        <td align="left">{$cuarentayuno.INPUT}</td>
    </tr>
    <tr class="letra12">
        <td align="left"><b>54 y m&aacute;s: <span  class="required">*</span></b></td>
        <td align="left">{$cincuentaycuatro.INPUT}</td>
        <td align="left">{$cincuentaycuatro.INPUT}</td>
    </tr>

</table>
<input class="button" type="hidden" name="id" value="{$ID}" />