<?php
	include_once 'ObjectAthlete.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Team Oarsome Challenge</title>
		<link rel="stylesheet" type="text/css" href="TOstyle.css">
		<link rel="shortcut icon" href="img/TO.ico" />
		<script type="text/javascript">
// copyright 1999 Idocs, Inc. http://www.idocs.com
// Distribute this script freely but keep this notice in place
		function numbersonly(myfield, e, dec)
		{
			var key;
			var keychar;

			if (window.event)
   				key = window.event.keyCode;
			else if (e)
   				key = e.which;
			else
   				return true;
   			
			keychar = String.fromCharCode(key);

// control keys
			if ((key==null) || (key==0) || (key==8) || 
    			(key==9) || (key==13) || (key==27) )
   				return true;

// numbers
			else if ((("0123456789").indexOf(keychar) > -1))
   				return true;

// decimal point jump
			else if (dec && (keychar == "."))
   		{
   				myfield.form.elements[dec].focus();
   				return false;
   		}
			else
   				return false;
		}

		</script>
	</head>
	
	<body>

		<div id="banner" > <img src="img/TObanner.png" alt="logo">TEAM OARSOME CHALLENGE</div>


		<div id = "month">
			Month:
			<select>
				<option>May 2014</option>
				<option>June 2014</option>
				<option>July 2014</option>
			</select>
		</div>
		
		<div id = "challenge">Row as fast as you can for as long as you can</div>

		<div id ="name">
			<select>
				<option>Arlene Wade</option>
				<option>Gregory Cook</option>
				<option>Fishing</option>
			</select>
		</div>
		
			<form action="../cgi-bin/mycgi.pl" method="POST">Meters <input
				name="dollar" size="5" maxlength="5"
				onkeypress="return numbersonly(this, event)"> <input
				type="SUBMIT" value="go"></form>

			Hours:
			<select>
				<option>0</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
			</select>
			Min:
			<select>
				<option>0</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
				<option>13</option>
				<option>14</option>
				<option>15</option>
				<option>16</option>
				<option>17</option>
			<option>18</option>
			<option>19</option>
	<option>20</option>
	<option>21</option>
	<option>22</option>
	<option>23</option>
	<option>24</option>
	<option>25</option>
	<option>26</option>
	<option>27</option>
	<option>28</option>
	<option>29</option>
	<option>30</option>
	<option>31</option>
	<option>32</option>
	<option>33</option>
	<option>34</option>
	<option>35</option>
	<option>36</option>
	<option>37</option>
	<option>38</option>
	<option>39</option>
	<option>40</option>
	<option>41</option>
	<option>42</option>
	<option>43</option>
	<option>44</option>
	<option>45</option>
	<option>46</option>
	<option>47</option>
	<option>48</option>
	<option>49</option>
	<option>50</option>
	<option>51</option>
	<option>52</option>
	<option>53</option>
	<option>54</option>
	<option>55</option>
	<option>56</option>
	<option>57</option>
	<option>58</option>
	<option>59</option>

</select>
Sec:
<select>
	<option>0</option>
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>6</option>
	<option>7</option>
	<option>8</option>
	<option>9</option>
</select>
<select>
	<option>.0</option>
	<option>.1</option>
	<option>.2</option>
	<option>.3</option>
	<option>.4</option>
	<option>.5</option>
	<option>.6</option>
	<option>.7</option>
	<option>.8</option>
	<option>.9</option>
</select>



</body>
</head>
</html>