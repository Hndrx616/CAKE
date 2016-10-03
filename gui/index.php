<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://rendro.github.io/easy-pie-chart/javascripts/jquery.easy-pie-chart.js"></script>
<script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script>
<script type="text/javascript" src="/catalystKey.js"></script>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,500,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/catalystKey-stylesheet.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>GIG Analytics Tool</title>
</head>
<body>
<div class='sidebar'>
    <div class='navigation-elm'><span class='nav-text'><i class="fa fa-fw fa-area-chart"></i><span class='text-short'>Analytics</span> <span class='text-long'>Dashboard</span></span></div>
    <div class='sub-navigation-elm'>Site Performance</div><div class='sub-navigation-elm'>Competitive Landscape</div> <div class='sub-navigation-elm'>Logistics Report</div><div class='sub-navigation-elm'>Get Traffic</div>
    <div id="hill-link" class='navigation-elm'><span class='nav-text'><i class="fa fa-fw fa-newspaper-o"></i><span class='text-short'>Campaign</span> <span class='text-long'>Overview</span></span></div>
    <div id="hill-link2"class='navigation-elm'><span class='nav-text'><i class="fa fa-fw fa-users"></i><span class='text-short'>Customer</span> <span class='text-long'>Database</span></span></div>
    <div id="hill-link3" class='navigation-elm'><span class='nav-text'><i class="fa fa-fw fa-users"></i><span class='text-short'>SEO</span> <span class='text-long'>Tools</span></span></div>
    <div id="hill-link4" class='navigation-elm'><span class='nav-text'><i class="fa fa-fw fa-comment"></i><span class='text-short'>Community</span> <span class='text-long'>Updates</span><div class='update-number'>3</div></span></div>
    <div id="hill-link5" class='navigation-elm'><span class='nav-text'><i class="fa fa-fw fa-comment"></i><span class='text-short'>Messages</span><div class='update-number'>5</div></span></div>
    <div id="hill-link6" class='navigation-elm'><span class='nav-text'><i class="fa fa-fw fa-gear"></i><span class='text-short'>Settings</span></span></div>
  </div>
  
<div class="v-tab"><ul class="tab__head">
<li id="t1" rel="tab1" style="font-size:14px;"><input id="radio-input-1" type="radio" value="myValue 1" name="radio-group"><label for="radio-input-1" class="input-helper input-helper--radio">
<p>Dashboard</p></label></li>
<li id="t2" rel="tab2" style="font-size:14px;"><input id="radio-input-2" type="radio" value="myValue 2" name="radio-group"><label for="radio-input-2" class="input-helper input-helper--radio">
<p>Metrics</p></label></li>
<li id="t3" rel="tab3" style="font-size:14px;"><input id="radio-input-3" type="radio" value="myValue 3" name="radio-group"><label for="radio-input-3" class="input-helper input-helper--radio">
<p>Page Detail</p></label></li>
<li id="t4" rel="tab4" style="font-size:14px;"><input id="radio-input-4" type="radio" value="myValue 4" name="radio-group"><label for="radio-input-4" class="input-helper input-helper--radio">
<p>Monitor</p></label></li>
<li id="t5" rel="tab5" style="font-size:14px;"><input id="radio-input-5" type="radio" value="myValue 5" name="radio-group"><label for="radio-input-5" class="input-helper input-helper--radio">
<p>CDN Search</p></label></li>
<li id="t6" rel="tab6" style="font-size:14px;"><input id="radio-input-6" type="radio" value="myValue 6" name="radio-group"><label for="radio-input-6" class="input-helper input-helper--radio">
<p>Workflow</p></label></li>
</ul>
<br>
<div class="tab__container">
<div id="tab1" class="tab__content">
<div class="picboxnoteslv" style="padding: 2px 2px; margin-top:35px;"><div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='coverlay'>
<div class='horizontal-bar-element'>
<span style="padding: 1em;"><u>Daily Visits</u></span>
<div class="horizontal-bar-graph" id="my-graph"></div></div>
<div class="chart-line-element" style="margin-left:-2.5px;">
<div id="Graph"></div>
</div>
<table style="float:right;"><tbody><tr><td>
<div class="dashwrap">
  	<div class="dashheader"><span>Keywords</span><div style="margin:0 0 0 1.5em;" class="dropdown">
    <select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Visits</option><option value="2">Bounce Rate</option><option value="3">Links</option></select>
  </div></div>
		<div class="dashwrap-list">
			<ol class="dashlist">
				<li><div class="label">Keyword Not Defined &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; 165</div></li>
				<li><div class="label">Internal Server Error&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;28</div></li>
        		<li><div class="label">All Websites&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;<em>N/A</em></div></li>
				<li><div class="label">Forums&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;<em>N/A</em></div></li>
				<li><div class="label">Images not in tcpdf report&emsp;&emsp;&emsp;&emsp;&emsp;1</div></li>
			</ol>
			<span style="margin-left:0.5em;"><input type="text" value="&nbsp;search..."><a href="#" style="margin-left:2.5em;color:blue;">NEXT>></a></span>
		</div>
	</div>
</div></td><td>
<div class="dashwrap">
  	<div class="dashheader"><span>Referrer Sites</span><div style="margin:0 0 0 1.5em;" class="dropdown">
    <select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Visits</option><option value="2">Bounce Rate</option><option value="3">Links</option></select>
  </div></div>
		<div class="dashwrap-list">
			<ol class="dashlist">
				<li><div class="label">Keyword Not Defined &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
				<li><div class="label">Internal Server Error &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
        		<li><div class="label">All Websites&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;<em>N/A</em></div></li>
				<li><div class="label">Forums&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;<em>N/A</em></div></li>
				<li><div class="label">Images not in tcpdf report&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
			</ol>
			<span style="margin-left:0.5em;"><input type="text" value="&nbsp;search..."><a href="#" style="margin-left:2.5em;color:blue;">NEXT>></a></span>
		</div>
	</div>
</div></td></tr><tr>
<td><div class="dashwrap">
  	<div class="dashheader"><span style="margin-left:-10px;">Search Engine</span><div style="margin:0 0 0 0.5em;" class="dropdown">
    <select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Visits</option><option value="2">Bounce Rate</option><option value="3">Links</option></select>
  </div></div>
		<div class="dashwrap-list">
			<ol class="dashlist">
				<li><div class="label">Google &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
				<li><div class="label">Bing&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<em>N/A</em></div></li>
				<li><div class="label">Ask&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<em>N/A</em></div></li>
        		<li><div class="label">Yahoo &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
				<li><div class="label">Live Search&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<em>N/A</em></div></li>
			</ol>
			<span style="margin-left:0.5em;"><input type="text" value="&nbsp;search..."><a href="#" style="margin-left:2.5em;color:blue;">NEXT>></a></span>
		</div>
	</div></td>
	<td>
<div class="dashwrap">
  	<div class="dashheader"><span style="margin-left:-10px;">Visit Browsers</span><div style="margin:0 0 0 0.5em;" class="dropdown">
    <select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Visits</option><option value="2">Bounce Rate</option><option value="3">Links</option></select>
  </div></div>
		<div class="dashwrap-list">
			<ol class="dashlist">
				<li><div class="label">Chrome &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
				<li><div class="label">Firefox&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
				<li><div class="label">Explorer&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
        		<li><div class="label">Safari&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
				<li><div class="label">Opera &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <em>N/A</em></div></li>
			</ol>
			<span style="margin-left:0.5em;"><input type="text" value="&nbsp;search..."><a href="#" style="margin-left:2.5em;color:blue;">NEXT>></a></span>
		</div>
	</div></td></tr></tbody></table>
	<main>
<h4 style="text-align:center;"><u>Traffic Sources</u></h4>
  <section>
    <div class="pieID pie"></div>
    <ul class="pieID legend">
      <li><em>Direct</em><span>400</span></li>
      <li><em>Referral</em><span>310</span></li>
      <li><em>Organics</em><span>260</span></li>
      <li><em>Feed</em><span>30</span></li>
    </ul>
  </section>
  </main>
  <div class='row'>
    <div class='piechart-element'><div class='piechart-label'>
        <div class='label-heading'>New Visits</div>
        <p class='small'>The percentage of visitors to the website who were unique new visitors browsing.<span class='main-color'>5% decrease</span>.</p></div><div id="container"><div class="chartrotate" data-percent="68"><div class='piechart-percent main-color'>68%</div></div></div>
      </div>
    <div class='piechart-element'><div class='piechart-label'>
        <div class='label-heading'>Bounce Rate</div>
        <p class='small'>The percentage of visitors to the website who navigate away from the site after viewing only one page.<span class='main-color'> 24% increase</span>.</p></div><div id="container"><div class="chartrotate" data-percent="49"><div class='piechart-percent main-color'>49%</div></div></div>
        </div>
    <div class='piechart-element'><div class='piechart-label'>
        <div class='label-heading'>Links Clicked</div>
        <p class='small'>The number of links clicked that were in relation to in site bounces and of that of our top keyword search.<span class='main-color'>15% increase</span>.</p></div><div id="container"><div class="chartrotate" data-percent="34"><div class='piechart-percent main-color'>34%</div></div></div>
        </div>
  </div>
</div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div></div></div>

<div id="tab2" class="tab__content">
<div class="picboxnoteslv" style="padding: 2px 2px; margin-top:35px;"><div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='element-header social'>Regional Performance Metrics</div>
<div class='row'><div class='stats-element'><div class='stats-container' id='stats-element'>
        <div class='map-container'>
          <div class='position-marker'></div><div class='position-marker no2'></div><div class='position-marker no3'></div><div class='position-marker no4'></div><div class='position-marker no5'></div><div class='position-marker no6'></div>
        </div>
        <div class='stats-table'>
          <div class='table-header'>
            <div class='country-select'>NORAM</div><div class='country-select'>EMEA</div><div class='country-select'>CIS</div><div class='country-select'>APAC</div><div class='country-select'>NACE</div><div class='country-select'>NCSA</div><div class='country-select'>LATAM</div>
          </div>
          <table class='performance-table'><tbody>
              <tr><td></td><td>Visits</td><td>Unique Visits</td><td>Page Views</td><td>Avg. Visit Duration</td><td>Bounce Rate</td><td>Page Per Visit</td></tr>
              <tr><td class='table-desc'>Today</td><td>160</td><td>131</td><td>407</td><td>0:05:25</td><td>60.98%</td><td>2.34</td></tr>
              <tr><td class='table-desc'>Week to Date</td><td>1,220</td><td>918</td><td>2854</td><td>0:03:21</td><td>60.98%</td><td>2.34</td></tr>
              <tr><td class='table-desc'>Month to Date</td><td>4,480</td><td>3,668</td><td>11.3k</td><td>0:03:21</td><td>60.98%</td><td>9.36</td></tr>
              <tr><td class='table-desc'>Year to Date</td><td>44k</td><td>37k</td><td>136.7k</td><td>0:05:25</td><td>60.98%</td><td>112.32</td></tr>
            </tbody></table></div></div></div>
    <div class='order-element'>
      <div class='element-header'></div>
      <div class='order-scroll up' id='order-scrollup'><i class="fa fa-chevron-up"></i></div>
      <div class='order-container' id='order-container'>
        <div class='order-item' id='order-item'>
          <h4>Ping #413-8148622</h4>
          <p>Status: <span class='main-color'>Finished</span><br>IPv6: 9851 1199 72</p>
          <p>Order Date: 06/21/16 03:03:29<br> Customer Contact: test.clark@gmail.com</p>
        </div>
        <div class='order-item'>
          <h4>Ping #313-55416218</h4>
          <p>Status: <span class='main-color'>Finished</span><br>IPv6: 1431 2349 11</p>
          <p>Date: 06/21/16 03:04:21<br> Customer Contact: random.guy@gmail.com</p>
        </div>
        <div class='order-item highlight'>
          <h4>Ping #535-71122781</h4>
          <p>Status: <span class='highlight'>Awaiting Connection</span><br>IPv6: -</p>
          <p>Date: 06/21/16 03:04:30<br> Customer Contact: aname.store@aol.com</p>
        </div>
        <div class='order-item highlight'>
          <h4>Ping #455-51133742</h4>
          <p>Status: <span class='highlight'>Awaiting Connection</span><br>IPv6: -</p>
          <p>Date: 06/21/16 03:05:21<br> Customer Contact: special.order@yahoo.com</p>
        </div>
        <div class='order-item hold'>
          <h4>Ping #734-45422551</h4>
          <p>Status: <span class='inactive'>On Hold</span><br>IPv6: -</p>
          <p>Date: 06/21/16<br> Customer Contact: nobody123@gmail.com</p>
        </div>
        <div class='order-item hold'>
          <h4>Ping #532-13422331</h4>
          <p>Status: <span class='inactive'>On Hold</span><br>IPv6: -</p>
          <p>Date: 06/21/16<br> Customer Contact: random333.star@gmail.com</p>
        </div>
        <div class='order-item hold'>
          <h4>Ping #922-25491351</h4>
          <p>Status: <span class='inactive'>On Hold</span><br>IPv6: -</p>
          <p>Date: 06/21/16<br> Customer Contact: santa@gmail.com</p>
        </div></div><div class='order-scroll' id='order-scrolldown'><i class="fa fa-chevron-down"></i></div></div></div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div></div></div>

<div id="tab3" class="tab__content">
<div class="picboxnoteslv" style="padding: 2px 2px; margin-top:35px;"><div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='element-header social'>Page Detail</div>
<div class='coverlay'>
<div class="spacingbox">
<table><tbody><tr><td><input type="text" style="width:150%;" value="Enter URL..."></td><td><input style="margin-left:6em;" type="submit" value="Enter"></td><td><div style="margin:0 0 0 1.5em;" class="dropdown">
    <select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Today</option><option value="2">Last 7 days</option><option value="3">Last Month</option></select>
  </div></td></tr></tbody></table>
 <table><tbody><tr><td><p style="color:#eee; text-align:center;"><u>Visitor Loyalty</u></p></td><td><p style="color:#eee; text-align:center;"><u>Reffering Search Terms</u></p></td></tr>
 <tr><td><div class="chart-line-element">
 <div id="Graph2"></div></div></td>
 <td><div class="chart-line-element">
 <div id="Graph3"></div></div></td></tr>
 <tr><td><p style="color:#eee; text-align:center;"><u>Dom Clicks: /?page_id=4</u></p></td><td><p style="color:#eee; text-align:center;"><u>Page Detail</u></p></td></tr>
 <tr><td><div class="chart-line-element">
 <div id="Graph4"></div></div></td>
 <td><div class="chart-line-element">
 <div id="Graph5"></div></div></td></tr></tbody></table>
</div></div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div></div></div>

<div id="tab4" class="tab__content">
<div class="picboxnoteslv" style="padding: 2px 2px; margin-top:35px;"><div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='element-header social'>3rd Party Analytics Monitoring</div>
<div class='coverlay' style="box-shadow:0px 2px 10px 0px #000;padding:1em; margin:1em;">
<form name="data_entry" action="#">
<table>
<thead><tr><th>Company Name: <input type="text" size="30" name="company_name"></th><th>Site URL: <input type="text" size="30" name="site_url"></th><th>Keywords: <input type="text" size="30" name="keyword_search"></th><th>Email Address: <input type="text" size="30" name="email"></th></tr></thead>
<tbody><tr><td>Select Business Type:</td></tr>
<tr><td><input type="checkbox" name="business_category" value="1"> Manufacturer</td><td><input type="checkbox" name="business_category" value="5"> Blog Article</td></tr>
<tr><td><input type="checkbox" name="business_category" value="2"> Whole Sale Supplier</td><td><input type="checkbox" name="business_category" value="6"> Chatboard Forum</td></tr>
<tr><td><input type="checkbox" name="business_category" value="3"> Retailer</td><td><input type="checkbox" name="business_category" value="7"> Database Company</td></tr>
<tr><td><input type="checkbox" name="business_category" value="4"> Ad Link Provider</td><td><input type="checkbox" name="business_category" value="8"> Search Engine Host</td></tr>
<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
<tr><td><input type="checkbox" name="privacy">Keep Information Private</td><td><input type="checkbox" name="privacy">Monitor Traffic</td><td><input type="button" name="reset_form" value="Reset Form" onclick="this.form.reset();"></td>
<td><input type="button" name="clear" value="Submit Form" onclick="confirm('Form Submitted');"></td></tr></tbody></table></form></div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div></div></div>

<div id="tab5" class="tab__content">
<div class="picboxnoteslv" style="padding: 2px 2px; margin-top:35px;"><div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='element-header social'>Content Delivery Network Search Index</div>
<div class='coverlay' style="box-shadow:0px 2px 10px 0px #000;padding:1em; margin:1em;">
<p class="title">CDN File Search:<button style="margin:2em;" type="button" id="submitButton" value="Reset Form" onClick="this.form.reset()" text="submit" value="Reset form" style="cursor:pointer;">Search</button></p><input type="text" id="searchBox" class="search-field" autoFocus /><ul id="searchResults" class="term-list hidden"></ul>
<p class="title">Replace:<button style="margin:2em;" type="button" id="submitButton" value="Reset Form" onClick="this.form.reset()" text="submit" value="Reset form" style="cursor:pointer;">Replace</button></p><input type="text" id="searchBox" class="search-field" autoFocus /><ul id="searchResults" class="term-list hidden"></ul>
<div style="height:100px;"></div></div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div></div></div>

<div id="tab6" class="tab__content">
<div class="picboxnoteslv" style="padding: 2px 2px; margin-top:35px;"><div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='element-header social'>Company Workflow</div>
  <div class='row todo'>
    <div class='social-element'>
      <div class='chatbox-container'><div class='anna-image'></div><div class='chatbox-left'><span class='username'>Stephen:</span>Hi <span class='highlight'>@Tom</span>, please make sure to have a look at <a href='#' class='main-color'>#413-8148622</a>, needs dispatch ASAP.</div></div>
      <div class='chatbox-container'><div class='anna-image'></div><div class='chatbox-left'><span class='username'>Stephen:</span>Aw sorry, forgot to attach the updated invoice.</div></div>
      <div class='chatbox-container'><div class='jimmy-image'></div><div class='chatbox-left'><span class='username'>Tom:</span>Hey <span class='highlight'>@Stephen</span>, don't you worry - I'm here to save the day. Order is already dispached!</div></div>
      <div style="height:50px;"></div>
      <div class='chat-input'>
        <textarea rows='1' placeholder='Add a comment to this workflow...'></textarea>
        <div class='submit-icon' onclick="confirm('Comment Added');"><i class="fa fa-paper-plane-o"></i></div>
      </div></div>
    <div class='todo-element'><div class='table-header todo'>
        <div class='country-select'>Files</div><div class='country-select'>Todos</div></div>
      <div class='file-container small'><ul>
          <li style="cursor:pointer;" onclick="confirm('Open File?');"><span><i class="fa fa-file-pdf-o"></i> invoice#413-814updated.pdf</span></li>
          <li style="cursor:pointer;" onclick="confirm('Open File?');"><i class="fa fa-file-excel-o"></i> revenue-summary.xls</li>
          <li style="cursor:pointer;" onclick="confirm('Open File?');"><i class="fa fa-file-pdf-o"></i> region30_map.pdf</li>
        </ul>
        <div class='draghere' onclick="confirm('Files Uploaded');"><i class="fa fa-lg fa-cloud-upload"></i>Drag new files here</div>
      </div></div></div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div></div></div>
</div></div>
<div class="hill-overlay">
<div class="hill-window">
<button class="close-button"><span>X</span></button>
<div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='coverlay' style="box-shadow:0px 2px 10px 0px #000;padding:1em; margin:1em;">
<p>test1</p>
</div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div>
</div></div>
 <div class="hill-overlay2">
<div class="hill-window2">
<button class="close-button2"><span>X</span></button>
<div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='coverlay' style="box-shadow:0px 2px 10px 0px #000;padding:1em; margin:1em;">
<p>test2</p>
</div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div>
</div></div>
<div class="hill-overlay3">
<div class="hill-window3">
<button class="close-button3"><span>X</span></button>
<div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='coverlay' style="box-shadow:0px 2px 10px 0px #000;padding:1em; margin:1em;">
<p>test3</p>
</div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div>
</div></div>
<div class="hill-overlay4">
<div class="hill-window4">
<button class="close-button4"><span>X</span></button>
<div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='coverlay' style="box-shadow:0px 2px 10px 0px #000;padding:1em; margin:1em;">
<p>test4</p>
</div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div>
</div></div>
<div class="hill-overlay5">
<div class="hill-window5">
<button class="close-button5"><span>X</span></button>
<div class="picboxsilver-old" style="padding: 2px;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='coverlay' style="box-shadow:0px 2px 10px 0px #000;padding:1em; margin:1em;">
<p>test5</p>
</div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div>
</div></div>
<div class="hill-overlay6">
<div class="hill-window6">
<button class="close-button6"><span>X</span></button>
<div class="picboxsilver-old" style="padding: 2em;" ><div class="picboxsilver-gradient-old" style="padding: 2px;" ><div class="borderbox40" style="padding: 2px 2px;"><div style="margin-left:5px;"><span style="font-family: Arial; font-size: 110%;"><span style="font-family: Arial; font-size: 100%;">
<div class='coverlay' style="box-shadow:0px 2px 10px 0px #000;padding:1em; margin:1em;">
<form name="data_entry" action="#">
<table>
<thead><tr><th>Settings 1: <input type="text" size="30" name="company_name"></th><th>Settings 2: <input type="text" size="30" name="site_url"></th></tr></thead>
<tbody>
<tr><td><input type="checkbox" name="business_category" value="1"> Option 1</td><td><div style="margin:0 0 0 1.5em;" class="dropdown"><select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></select>
</div></td>
<td><input type="checkbox" name="business_category" value="5"> Option 5</td><td><div style="margin:0 0 0 1.5em;" class="dropdown"><select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></select>
</div></td></tr>
<tr><td><input type="checkbox" name="business_category" value="2"> Option 2</td><td><div style="margin:0 0 0 1.5em;" class="dropdown"><select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></select>
</div></td>
<td><input type="checkbox" name="business_category" value="6"> Option 6</td><td><div style="margin:0 0 0 1.5em;" class="dropdown"><select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></select>
</div></td></tr>
<tr><td><input type="checkbox" name="business_category" value="3"> Option 3</td><td><div style="margin:0 0 0 1.5em;" class="dropdown"><select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></select>
</div></td>
<td><input type="checkbox" name="business_category" value="7"> Option 7</td><td><div style="margin:0 0 0 1.5em;" class="dropdown"><select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></select>
</div></td></tr>
<tr><td><input type="checkbox" name="business_category" value="4"> Option 4</td><td><div style="margin:0 0 0 1.5em;" class="dropdown"><select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></select>
</div></td>
<td><input type="checkbox" name="business_category" value="8"> Option 8</td><td><div style="margin:0 0 0 1.5em;" class="dropdown"><select name="one" class="dropdown-select">
      <option value="">Select…</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></select>
</div></td></tr>
<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
<td><input type="button" name="clear" value="Save Changes" onclick="confirm('Changes Saved');"></td>
<td><input type="button" name="reset_form" value="Reset Defaults" onclick="this.form.reset('Setteings Reset');"></td></tr></tbody></table></form>
</div>
</span></span></div></div></div><div class="picboxpage-shadow-old"></div></div>
</div></div>
</body>
</html>