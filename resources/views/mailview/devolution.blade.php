<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<head>
	</head>
	<body style='margin: 0; padding: 0;'>
		 <table border='0' cellpadding='0' cellspacing='0' width='100%'>
			<tr>
				 <td>
				  <table align='center' border='0' cellpadding='0'  cellspacing='0'  width='600' style='border-collapse: collapse;'>
						 <tr>
							<td style='padding: 10px 0 20px 0;'>
							 <table align='center' border='0' cellpadding='0' cellspacing='0' width='600'>
								 	<tr>
										<td align='center' bgcolor='#24bddf' style='padding: 40px 0 30px 0; font-family: sans-serif; font-size: 18px; line-height: 20px;'>
										 	<h3>DEVOLUCIÓN</h3>
										</td>
									 </tr>
									 <tr>
										<td bgcolor='#FBF9F9' style='padding: 40px 30px 40px 30px;'>
											 <table border='0' cellpadding='0' cellspacing='0'  width='100%'>
									 	 	 	<tr>
									 	 			 <td style="padding: 10px 0 20px 0;color: black; font-family: sans-serif; font-size: 18px; line-height: 15px;">
									 	 			  <b>Email del cliente:</b> {{$email}}
									 	 			 </td>
									 	 		</tr>
									 	 	 	<tr>
									 	 			 <td style="padding: 10px 0 20px 0;color: black; font-family: sans-serif; font-size: 18px; line-height: 15px;">
									 	 			  <b>Orden ID:</b> {{$order_id}}
									 	 			 </td>
									 	 		</tr>
									 	 	 	<tr>
									 	 			 <td style="padding: 10px 0 20px 0;color: black; font-family: sans-serif; font-size: 18px; line-height: 15px; text-align: justify;">
									 	 			  <b>Razón:</b> {{$reason}}
									 	 			 </td>
									 	 		</tr>
											 </table>
										</td>
									 </tr>
									 <tr>
										<td bgcolor='#24bddf' style='padding: 30px 30px 30px 30px;'>
										 	<table  border='0' cellpadding='0' cellspacing='0'  width='100%'>
												 <tr>
													<td style="color: white; font-family: sans-serif; font-size: 14px;">
													 Correo enviado desde el ecommerce PHARA
													</td>
													<td style="color: white; font-family: sans-serif; font-size: 14px;">
													 Fecha: {{$date}}
													</td>
												 </tr>
											</table>
										</td>
								 	</tr>
								</table>
							</td>
						 </tr>
					</table>
				 </td>
			</tr>
		 </table>
	</body>
</html>
