
<!DOCTYPE html>
<!-- saved from url=(0023)http://localhost:49558/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>EasterIsland Framework</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_CSS_PATH ?>metro-bootstrap.css" />
        <!-- PARAM GRID -->
        <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>grid/pqgrid.min.css" />

        <style>
            body
            {
                padding-top: 70px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    <body data-spy="scroll" data-target=".subnav" data-offset="50" screen_capture_injected="true">

        <div class="row">
            <div class="subnav navbar-fixed-top" style="-webkit-box-shadow: 0 1px 10px rgba(0,0,0,.1);box-shadow: 0 1px 10px rgba(0,0,0,.1); background: #fff">
                <div class="span12 inner" style="float: none; margin: 0 auto;">   
                    <h3 class="span2" style=" margin-bottom: 0px;padding: 0; text-transform: none; margin-left: 0; margin-top: 0px;">EasterIsland</h3>
                    <ul class="nav nav-pills span10" style="margin-bottom: 5px; margin-top: 10px;">
                        <li><a href="#badges">Basic Information</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Installation<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#buttonGroups">Downloading Code</a></li>
                                <li><a href="#buttonDropdowns">Button dropdowns</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Introduction <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#navs">Nav, tabs, pills</a></li>
                                <li><a href="#navbar">Navbar</a></li>
                                <li><a href="#breadcrumbs">Breadcrumbs</a></li>
                                <li><a href="#pagination">Pagination</a></li>
                            </ul>
                        </li>
                        <li><a href="#labels">Tutorial</a></li>
                        <li><a href="#badges">Utilities</a></li>
                        <li><a href="#typography">References</a></li>
                    </ul>
                </div>
            </div>   
        </div>
        <!-- Navbar
        ================================================== 
        <div class="navbar navbar-fixed-top">
             <div class="navbar-inner" style="font-size: 12px;">
                   <div class="container">
                     <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                     </a>
                     <a class="brand" href="#" style="margin-top: 5px;">EasterIsland</a>
                     <div class="nav-collapse">
                       <ul class="nav">
                         <li class="active"><a href="#">Home</a></li>
                         <li><a href="#">Link</a></li>
                         <li><a href="#">Link</a></li>
                         <li><a href="#">Link</a></li>
                         <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                           <ul class="dropdown-menu">
                             <li><a href="#">Action</a></li>
                             <li><a href="#">Another action</a></li>
                             <li><a href="#">Something else here</a></li>
                             <li class="divider"></li>
                             <li class="nav-header">Nav header</li>
                             <li><a href="#">Separated link</a></li>
                             <li><a href="#">One more separated link</a></li>
                           </ul>
                         </li>
                       </ul>
                       <form class="navbar-search pull-right" action="" novalidate="novalidate">
                         <input type="text" class="search-query span2" placeholder="Search">
                       </form>
                     </div><!-- /.nav-collapse
                   </div>
                 </div>
        </div>-->
        <div class="container">
            <!--<div class="span3">
      
             <ul class="nav nav-list">
     
               <li class="nav-header">Sidebar</li>
               <li class="active"><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li class="nav-header">Sidebar</li>
     
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
     
               <li class="nav-header">Sidebar</li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
               <li><a href="#"><i class="icon-book"></i>Link</a></li>
             </ul>
        </div> -->

            <div class="row">
                <div class="hero-unit">
                    <h1>Welcome to EasterIsland!</h1>
                    <p>EasterIsland is developed by Web Outsourcing-Gateway. EasterIsland is best user for Rapid Application Development. It is very highly customizable using MVC method which modules can be easily integrated to the framework. </p>
                    <p><a class="btn btn-primary btn-large">Learn more »</a></p>
                </div>
                <div class="row-fluid">

                    <div class="span8">
                        <h2>Intergrated with HighChart JS</h2>
                        <div id="lagyanngchart"></div>
                    </div><!--/span-->
                    <div class="span4">
                        <h2>Highchart Pie</h2>
                        <div id="piepiechart"></div>

                    </div><!--/span-->
                </div><!--/row-->

                <div class="row-fluid">
                    <div class="span8">
                        <h2>Grid System Powered by ParamGrid.</h2>    
                        <div>
                            <div id="grid_array"></div>
                        </div>
                    </div><!--/span-->
                    <div class="span4">
                        <h2>Time Ago</h2>    
                        <div>
                            <abbr class="timeago" title="February 10, 1986"></abbr> <br/>
                            <abbr class="timeago1" title="03/10/2012"></abbr> <br/>
                            <abbr class="timeago2"></abbr>
                        </div>
                    </div>
                </div><!--/row-->


                <h2>CkEditor.</h2>      
                <div class="row-fluid">
                    <div class="span8">
                        <div style="float: left;">
                            <textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10">
				&lt;h1&gt;&lt;img alt=&quot;Saturn V carrying Apollo 11&quot; class=&quot;right&quot; src=&quot;assets/sample.jpg&quot;/&gt; Apollo 11&lt;/h1&gt; &lt;p&gt;&lt;b&gt;Apollo 11&lt;/b&gt; was the spaceflight that landed the first humans, Americans &lt;a href=&quot;http://en.wikipedia.org/wiki/Neil_Armstrong&quot; title=&quot;Neil Armstrong&quot;&gt;Neil Armstrong&lt;/a&gt; and &lt;a href=&quot;http://en.wikipedia.org/wiki/Buzz_Aldrin&quot; title=&quot;Buzz Aldrin&quot;&gt;Buzz Aldrin&lt;/a&gt;, on the Moon on July 20, 1969, at 20:18 UTC. Armstrong became the first to step onto the lunar surface 6 hours later on July 21 at 02:56 UTC.&lt;/p&gt; &lt;p&gt;Armstrong spent about &lt;s&gt;three and a half&lt;/s&gt; two and a half hours outside the spacecraft, Aldrin slightly less; and together they collected 47.5 pounds (21.5&amp;nbsp;kg) of lunar material for return to Earth. A third member of the mission, &lt;a href=&quot;http://en.wikipedia.org/wiki/Michael_Collins_(astronaut)&quot; title=&quot;Michael Collins (astronaut)&quot;&gt;Michael Collins&lt;/a&gt;, piloted the &lt;a href=&quot;http://en.wikipedia.org/wiki/Apollo_Command/Service_Module&quot; title=&quot;Apollo Command/Service Module&quot;&gt;command&lt;/a&gt; spacecraft alone in lunar orbit until Armstrong and Aldrin returned to it for the trip back to Earth.&lt;/p&gt; &lt;h2&gt;Broadcasting and &lt;em&gt;quotes&lt;/em&gt; &lt;a id=&quot;quotes&quot; name=&quot;quotes&quot;&gt;&lt;/a&gt;&lt;/h2&gt; &lt;p&gt;Broadcast on live TV to a world-wide audience, Armstrong stepped onto the lunar surface and described the event as:&lt;/p&gt; &lt;blockquote&gt;&lt;p&gt;One small step for [a] man, one giant leap for mankind.&lt;/p&gt;&lt;/blockquote&gt; &lt;p&gt;Apollo 11 effectively ended the &lt;a href=&quot;http://en.wikipedia.org/wiki/Space_Race&quot; title=&quot;Space Race&quot;&gt;Space Race&lt;/a&gt; and fulfilled a national goal proposed in 1961 by the late U.S. President &lt;a href=&quot;http://en.wikipedia.org/wiki/John_F._Kennedy&quot; title=&quot;John F. Kennedy&quot;&gt;John F. Kennedy&lt;/a&gt; in a speech before the United States Congress:&lt;/p&gt; &lt;blockquote&gt;&lt;p&gt;[...] before this decade is out, of landing a man on the Moon and returning him safely to the Earth.&lt;/p&gt;&lt;/blockquote&gt; &lt;h2&gt;Technical details &lt;a id=&quot;tech-details&quot; name=&quot;tech-details&quot;&gt;&lt;/a&gt;&lt;/h2&gt; &lt;table align=&quot;right&quot; border=&quot;1&quot; bordercolor=&quot;#ccc&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot; style=&quot;border-collapse:collapse;margin:10px 0 10px 15px;&quot;&gt; &lt;caption&gt;&lt;strong&gt;Mission crew&lt;/strong&gt;&lt;/caption&gt; &lt;thead&gt; &lt;tr&gt; &lt;th scope=&quot;col&quot;&gt;Position&lt;/th&gt; &lt;th scope=&quot;col&quot;&gt;Astronaut&lt;/th&gt; &lt;/tr&gt; &lt;/thead&gt; &lt;tbody&gt; &lt;tr&gt; &lt;td&gt;Commander&lt;/td&gt; &lt;td&gt;Neil A. Armstrong&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;Command Module Pilot&lt;/td&gt; &lt;td&gt;Michael Collins&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td&gt;Lunar Module Pilot&lt;/td&gt; &lt;td&gt;Edwin &amp;quot;Buzz&amp;quot; E. Aldrin, Jr.&lt;/td&gt; &lt;/tr&gt; &lt;/tbody&gt; &lt;/table&gt; &lt;p&gt;Launched by a &lt;strong&gt;Saturn V&lt;/strong&gt; rocket from &lt;a href=&quot;http://en.wikipedia.org/wiki/Kennedy_Space_Center&quot; title=&quot;Kennedy Space Center&quot;&gt;Kennedy Space Center&lt;/a&gt; in Merritt Island, Florida on July 16, Apollo 11 was the fifth manned mission of &lt;a href=&quot;http://en.wikipedia.org/wiki/NASA&quot; title=&quot;NASA&quot;&gt;NASA&lt;/a&gt;&amp;#39;s Apollo program. The Apollo spacecraft had three parts:&lt;/p&gt; &lt;ol&gt; &lt;li&gt;&lt;strong&gt;Command Module&lt;/strong&gt; with a cabin for the three astronauts which was the only part which landed back on Earth&lt;/li&gt; &lt;li&gt;&lt;strong&gt;Service Module&lt;/strong&gt; which supported the Command Module with propulsion, electrical power, oxygen and water&lt;/li&gt; &lt;li&gt;&lt;strong&gt;Lunar Module&lt;/strong&gt; for landing on the Moon.&lt;/li&gt; &lt;/ol&gt; &lt;p&gt;After being sent to the Moon by the Saturn V&amp;#39;s upper stage, the astronauts separated the spacecraft from it and travelled for three days until they entered into lunar orbit. Armstrong and Aldrin then moved into the Lunar Module and landed in the &lt;a href=&quot;http://en.wikipedia.org/wiki/Mare_Tranquillitatis&quot; title=&quot;Mare Tranquillitatis&quot;&gt;Sea of Tranquility&lt;/a&gt;. They stayed a total of about 21 and a half hours on the lunar surface. After lifting off in the upper part of the Lunar Module and rejoining Collins in the Command Module, they returned to Earth and landed in the &lt;a href=&quot;http://en.wikipedia.org/wiki/Pacific_Ocean&quot; title=&quot;Pacific Ocean&quot;&gt;Pacific Ocean&lt;/a&gt; on July 24.&lt;/p&gt; &lt;hr/&gt; &lt;p style=&quot;text-align: right;&quot;&gt;&lt;small&gt;Source: &lt;a href=&quot;http://en.wikipedia.org/wiki/Apollo_11&quot;&gt;Wikipedia.org&lt;/a&gt;&lt;/small&gt;&lt;/p&gt;
                            </textarea>              
                        </div>
                    </div><!--/span-->
                    <div class="span4">
                        <table id="gravity" cellspacing="5" class="table">
                            <tbody><tr>
                                    <td>
                                        <a id="north-west" href="#" original-title="This is an example of north-west gravity">Northwest</a>
                                    </td>
                                    <td>
                                        <a id="north" href="#" original-title="This is an example of north gravity">North</a>
                                    </td>
                                    <td>
                                        <a id="north-east" href="#" original-title="This is an example of north-east gravity">Northeast</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a id="west" href="#" original-title="This is an example of west gravity">West</a>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <a id="east" href="#" original-title="This is an example of east gravity">East</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a id="south-west" href="#" original-title="This is an example of south-west gravity">Southwest</a>
                                    </td>
                                    <td>
                                        <a id="south" href="#" original-title="This is an example of south gravity">South</a>
                                    </td>
                                    <td>
                                        <a id="south-east" href="#" original-title="This is an example of south-east gravity">Southeast</a>
                                    </td>
                                </tr>
                            </tbody></table>        
                    </div>
                </div><!--/row-->      
            </div>      

        </div>
        <div class="container">
            <footer class="footer span12">

                <p>POWERED by: <a href="#"> Web Outsourcing Gateway. </a></p>
            </footer>   
        </div>
        <!-- /container -->
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-alert.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-button.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-carousel.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-collapse.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-modal.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-popover.js"></script>
        <!-- <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-scrollspy.js"></script> -->
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-tab.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-transition.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-typeahead.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.validate.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.validate.unobtrusive.js"></script>
        <script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.unobtrusive-ajax.js"></script>
        <!-- Highchart! -->
        <script src="<?php echo PUBLIC_JS_PATH ?>highchart/js/highcharts.js"></script>
        <script src="<?php echo PUBLIC_JS_PATH ?>highchart/js/modules/exporting.js"></script>

        <!-- Param Grid -->
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
        <script src="<?php echo PUBLIC_JS_PATH ?>grid/pqgrid.min.js"></script>

        <!-- CKEditor -->
        <script src="<?php echo PUBLIC_JS_PATH ?>ckeditor/ckeditor.js"></script>

        <!-- Time Ago -->
        <script src="<?php echo PUBLIC_JS_PATH ?>timeago/jquery.timeago.js" type="text/javascript"></script>


        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'lagyanngchart',
                            type: 'line',
                            marginRight: 130,
                            marginBottom: 25
                        },
                        title: {
                            text: 'Monthly Average Temperature',
                            x: -20 //center
                        },
                        subtitle: {
                            text: 'Source: WorldClimate.com',
                            x: -20
                        },
                        xAxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                        },
                        yAxis: {
                            title: {
                                text: 'Temperature (°C)'
                            },
                            plotLines: [{
                                    value: 0,
                                    width: 1,
                                    color: '#808080'
                                }]
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                    this.x +': '+ this.y +'°C';
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -10,
                            y: 100,
                            borderWidth: 0
                        },
                        series: [{
                                name: 'Tokyo',
                                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                            }, {
                                name: 'New York',
                                data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                            }, {
                                name: 'Berlin',
                                data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
                            }, {
                                name: 'London',
                                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                            }]
                    });
                });
    
            });

            $(function () {
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'piepiechart',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        title: {
                            text: 'Browser market shares'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                            percentageDecimals: 1
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#000000',
                                    connectorColor: '#000000',
                                    formatter: function() {
                                        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                                    }
                                }
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'Browser share',
                                data: [
                                    ['Firefox',   45.0],
                                    ['IE',       26.8],
                                    {
                                        name: 'Chrome',
                                        y: 12.8,
                                        sliced: true,
                                        selected: true
                                    },
                                    ['Safari',    8.5],
                                    ['Opera',     6.2],
                                    ['Others',   0.7]
                                ]
                            }]
                    });
                });
                var arrayData = [[1, 'Exxon Mobil', '339,938.0', '36,130.0'],
                    [2, 'Wal-Mart Stores', '315,654.0', '11,231.0'],
                    [3, 'Royal Dutch Shell', '306,731.0', '25,311.0'],
                    [4, 'BP', '267,600.0', '22,341.0'],
                    [5, 'General Motors', '192,604.0', '-10,567.0'],
                    [6, 'Chevron', '189,481.0', '14,099.0'],
                    [7, 'DaimlerChrysler', '186,106.3', '3,536.3'],
                    [8, 'Toyota Motor', '185,805.0', '12,119.6'],
                    [9, 'Ford Motor', '177,210.0', '2,024.0'],
                    [10, 'ConocoPhillips', '166,683.0', '13,529.0'],
                    [11, 'General Electric', '157,153.0', '16,353.0'],
                    [12, 'Total', '152,360.7', '15,250.0'],
                    [13, 'ING Group', '138,235.3', '8,958.9'],
                    [14, 'Citigroup', '131,045.0', '24,589.0'],
                    [15, 'AXA', '129,839.2', '5,186.5'],
                    [16, 'Allianz', '121,406.0', '5,442.4'],
                    [17, 'Volkswagen', '118,376.6', '1,391.7'],
                    [18, 'Fortis', '112,351.4', '4,896.3'],
                    [19, 'Crédit Agricole', '110,764.6', '7,434.3'],
                    [20, 'American Intl. Group', '108,905.0', '10,477.0']];


                var obj = { width: 700, height: 400, title: "Resizable Grid" };
                obj.colModel = [{ title: "Rank", width: 100 }, { title: "Company", width: 200 }, 
                    { title: "Revenues ($ millions)", width: 150 },
                    { title: "Profits ($ millions)", width: 150}];
                obj.dataModel = { data: arrayData };
                $("#grid_array").pqGrid(obj);  
                $("#grid_array").pqGrid("option", "resizable", true);
        
                //THIS FOR THE TIME AGO
                jQuery("abbr.timeago").timeago();
                jQuery("abbr.timeago1").timeago();
                var tt2 = jQuery.timeago(new Date());
                $("abbr.timeago2").html(tt2);

            });

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36060270-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>

    </body>
</html>