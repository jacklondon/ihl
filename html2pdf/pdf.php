<?php

include("../ayar.php");
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
if(re("q")=="uyelik_pdf_olustur"){
	$sql=mysql_query("select * from pdf_detay where id='".re("id")."'");
	$fetch=mysql_fetch_array($sql);
	$html = '<style>
            * {
                font-family: "DejaVu Sans Mono", monospace;
                box-sizing:border-box;
            }
			div.page_break + div.page_break{
				page-break-before: always;
			}
			
			 @page {
                margin: 100px 25px;
            }
			
			 footer {
                position: fixed; 
                bottom: -30px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }
			
			.first_page
			{
				width:740px;
				height:980px;
				background-color:#dadada;
				margin-top:-80px;
				text-align:center;
				font-size:25px;
				line-height:450px;
				font-weight:700;
			}
			</style>';
	$html.='<div class="first_page">
				Üyelik Sözleşmesi
			</div>'.$fetch["uyelik_detay"];
	$html.='<footer>asdasdasdasd</footer>';


	$filename = "odeme_bildirimi";
	$options = new Options();
	$options->set('isRemoteEnabled', TRUE);
	$dompdf = new Dompdf($options);
	$dompdf->loadHtml($html,'UTF-8');
	$dompdf->setPaper('A4', 'portraid');
	$dompdf->render();
	$dompdf->stream($filename,array("Attachment"=>0)); //0->show 1->dowloand

}






