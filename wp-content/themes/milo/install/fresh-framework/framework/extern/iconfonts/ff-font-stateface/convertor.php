<?php

exit;


echo "<h1>Convertor</h1><pre>";

$css = "ak A
al B
ar C
az D
ca E
co F
ct G
dc y
de H
fl I
ga J
hi K
ia L
id M
il N
in O
ks P
ky Q
la R
ma S
md T
me U
mi V
mn W
mo X
ms Y
mt Z
nc a
nd b
ne c
nh d
nj e
nm f
nv g
ny h
oh i
ok j
or k
pa l
pr 3
ri m
sc n
sd o
tn p
tx q
us z
ut r
va s
vt t
wa u
wi v
wv w
wy x";

$states = "Alabama	 Ala.	 AL
Alaska	 Alaska	 AK
American Samoa	  	 AS
Arizona	 Ariz.	 AZ
Arkansas	 Ark.	 AR
California	 Calif.	 CA
Colorado	 Colo.	 CO
Connecticut	 Conn.	 CT
Delaware	 Del.	 DE
Dist. of Columbia	 D.C.	 DC
Florida	 Fla.	 FL
Georgia	 Ga.	 GA
Guam	 Guam	 GU
Hawaii	 Hawaii	 HI
Idaho	 Idaho	 ID
Illinois	 Ill.	 IL
Indiana	 Ind.	 IN
Iowa	 Iowa	 IA
Kansas	 Kans.	 KS
Kentucky	 Ky.	 KY
Louisiana	 La.	 LA
Maine	 Maine	 ME
Maryland	 Md.	 MD
Marshall Islands	  	 MH
Massachusetts	 Mass.	 MA
Michigan	 Mich.	 MI
Micronesia	  	 FM
Minnesota	 Minn.	 MN
Mississippi	 Miss.	 MS
Missouri	 Mo.	 MO
Montana	 Mont.	 MT
Nebraska	 Nebr.	 NE
Nevada	 Nev.	 NV
New Hampshire	 N.H.	 NH
New Jersey	 N.J.	 NJ
New Mexico	 N.M.	 NM
New York	 N.Y.	 NY
North Carolina	 N.C.	 NC
North Dakota	 N.D.	 ND
Northern Marianas	  	 MP
Ohio	 Ohio	 OH
Oklahoma	 Okla.	 OK
Oregon	 Ore.	 OR
Palau	  	 PW
Pennsylvania	 Pa.	 PA
Puerto Rico	 P.R.	 PR
Rhode Island	 R.I.	 RI
South Carolina	 S.C.	 SC
South Dakota	 S.D.	 SD
Tennessee	 Tenn.	 TN
Texas	 Tex.	 TX
Utah	 Utah	 UT
Vermont	 Vt.	 VT
Virginia	 Va.	 VA
Virgin Islands	 V.I.	 VI
Washington	 Wash.	 WA
West Virginia	 W.Va.	 WV
Wisconsin	 Wis.	 WI
Wyoming	 Wyo.	 WY";

$css = explode("\n", $css);

$mine = array();

foreach($css as $line){
	$line = trim($line);
	list( $code, $char ) = explode(' ', $line);
	$mine[ strtolower($code) ] = array( 'char' => $char);
}

$states = explode("\n", $states);
foreach($states as $line){
	$line = trim($line);
	list( $name, $abbreviation, $code ) = explode("\t", $line);

	if( ! isSet( $mine[ trim( strtolower($code) ) ] ) ){
		continue;
	}
	
	$mine[ trim( strtolower($code) ) ]['name'] = $name;
	$mine[ trim( strtolower($code) ) ]['abbreviation'] = $abbreviation;
	$mine[ trim( strtolower($code) ) ]['code'] = $code;
}

$mine[ 'us' ]['name'] = 'United States of America';
$mine[ 'us' ]['abbreviation'] = "us";
$mine[ 'us' ]['code'] = "USA";

foreach($mine as $key=>$item){
	echo ".ff-font-stateface.icon-";
	echo $key;
	echo ":before { content: '\\";
	echo dechex( ord( $item['char'] ) );
	echo "'; }";
	echo " /* ";
	echo $item['name'];
	//echo " ";
	//echo $item['abbreviation'];
	echo " ";
	echo $item['code'];
	echo " */ ";
	echo "\n";
}

print_r($mine);


