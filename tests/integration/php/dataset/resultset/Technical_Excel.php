<?php
/**
 * Resultset for F_Technical_Excel_Service
 * 
 * array[<nameTestFunction>] = json result
 * 
 *  @return array
 */
return array(
	'testToArrayWithExcel5AlreadyOpenSuccess' => '[["header1","header2","header3"],["row1,1","row1,2","row1,3"],["un texte avec des caract\u00e8res","je rajoute des acract\u00e8re diacritique en colone 3","\u00f9\u00e7\u00e8\u00e9\u00e0"]]',
	'testToArrayWithExcel2007Success'         => '[["header1","header2","header3"],["row1,1","row1,2","row1,3"],["un texte avec des caract\u00e8res","je rajoute des acract\u00e8re diacritique en colone 3","\u00f9\u00e7\u00e8\u00e9\u00e0"]]',
	'testToArrayWithInfectedColumnDataSuccess'=> '[["header1","header2","header3"],["row1,1","row1,2","row1,3"],["un texte avec des caract\u00e8res","je rajoute des acract\u00e8re diacritique en colone 3","\u00f9\u00e7\u00e8\u00e9\u00e0"]]',
	'testToArrayWithInfectedRowDataSuccess'=> '[["header1","header2","header3"],["row1,1","row1,2","row1,3"],["un texte avec des caract\u00e8res","je rajoute des acract\u00e8re diacritique en colone 3","\u00f9\u00e7\u00e8\u00e9\u00e0"]]',
		
);