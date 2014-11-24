[SKETCHY](http://www.pcwitz.org/sketchy)
====================

ABSTRACT
---------------------
In this paper, we describe the web application and social media site for Scalable Vector Graphics (SVG) called Sketchy.

### Categories and Subject Descriptors
D.2.6 [Software Engineering]: Programming Environments – graphical environments. H.5.2 [Information Services and Presentation (e.g., HCI)]: Programming Environments – graphical user interfaces, screen design, standardization. I.3.6 [Computer Graphics]: Methodology and Techniques – graphics data structures and data types, languages, standards.

### General Terms
Design, Standardization, Languages.

### Keywords
Scalable Vector Graphic (SVG), Document Object Model (DOM), Responsive Web Design, Social Media, File Sharing, Open Source.

1. INTRODUCTION
---------------------
Scalable Vector Graphics (SVG) is an XML-based vector image format for two-dimensional graphics that has support for interactivity and animation. The SVG specification is an open standard developed by the World Wide Web Consortium (W3C) since 1999. Many applications use SVG (a standard based on XML) to render drawings. The list includes apps such as Inkpad, iDraw, iDesign, SVG Notes, Inkscape, the illustrious Adobe Illustrator, and many others. This is about making a social network site that uses SVG code, drawn using any SVG-generating app, and allowing users to post the sketch to the Sketchy site—theoretically, the option to post, i.e. upload, would be available on any self- respecting SVG app...kind of like Pinterest, but for original vector graphics.

2. THE SITUATION
---------------------
With the evident popularity of tablets and touchscreen technology, drawing without pencil and paper is quickly becoming the norm. Native digital drawings born of tablets and styli need a place to live, to breathe, to be seen, and be shared...in the cloud.

Permission to make digital or hard copies of all or part of this work for personal or classroom use is granted without fee provided that copies are not made or distributed for profit or commercial advantage and that copies bear this notice and the full citation on the first page. To copy otherwise, or republish, to post on servers or to redistribute to lists, requires prior specific permission and/or a fee.

In addition, browser support for SVG is quickly improving. Also, putting the S in SVG is scalability, and the consequent growth of responsive design due to the need for sites to span many devises, especially mobile, makes SVG the perfect fit.

3. USERS AND AUDIENCE
---------------------
### 3.1 Graphic Artists
Graphic artists are particularly interested in the visual representation of graphics on the screen for marketing and other industry purposes. Their profession is increasingly technical and the uses of SVG code well within the range of their exploration.

### 3.2 SVG Enthusiasts
There may be rather only a few self-described SVG enthusiasts, but there are enough to make a mark. Underlying the many applications that assist in rendering vector graphics (as listed in the Introduction) is a group of enthusiasts interested in the many uses of SVG.

### 3.3 Web Designers and Programmers
The scalability of SVG gives it a major advantage with the multiplicity of devices interfacing with the web. Web design has to adapt to an ever-changing viewport and SVG can be scaled to suit each one. SVG images are zoomable and the image retains its resolution without degradation.

Web programmers have new opportunities since every element and every attribute in SVG files can be animated or DOM-modified. Furthermore, in HTML5, SVG elements can be embedded directly into HTML pages for use in native web applications. Incorporating graphics into web applications and using JavaScript for interactivity could produce more powerful web applications.

### 3.4 Social Media
Web applications allowing sharing are now culturally pervasive. Uploading images to Sketchy allows for browsing and sharing by artist or subject; and full-text database searches querying tags, descriptions, and titles. Solid-state database storage allows for anytime retrieval and association-building functionality. User registration allows for sketch identification by user, including personalized descriptions of each graphical upload.

The site allows for open source SVG code exchange (on a click you can grab the code, i.e., "click graphic for SVG code") for use by anyone interested in using the SVG displayed for their own use on the web, possibly on their own website, etc.

One condition for submitting is unlicensed use by anyone. We follow an open source model, in keeping with the spirit of SVG as an open source standard.

4. UPLOAD
---------------------
The app allows for sketches uploaded as either .svg or .xml file types. A unique folder is created for each user and each submission is given a unique file name as well, each of which are identical to the primary key created in the database.

On upload, the user is required to include a title of the sketch and given the option of up to three tags for interactive association with other sketches. The upload is concluded with a preview of the sketch and the option to write a description.

The uploaded SVG is then modified to accommodate the web design framework. In particular, it is very difficult to edit a SVG to fit in a predetermined frame. We then use DOM manipulation to remove the width and height attribute of the svg root element on upload because when these attributes are included the file cannot be appropriately scaled to a new page. Width and height in a svg element create a viewport which determines the size of the drawing seen in proportion to the entire drawing. By deleting width and height we make sure the viewport is the size of the viewBox, meaning you can see the entire graphic uploaded, not just a portion.

Then we preserve the viewBox if one already exists and create one if it doesn’t already have. The program uses a versatile scaling that can capture most graphics.

5. FEATURES
---------------------
### 5.1 SVG Code
The SVG code for each graphic in Sketchy can be viewed by clicking on the graphic itself. A background display is overlaid each graphic on hover that says “click graphic for SVG code”. This makes for quick and convenient viewing of the code which can then easily be copied into another application or file.

### 5.2 Presentation
To achieve the cascading grid layout we employ [Masonry](http://masonry.desandro.com), released under the MIT License, to allow for placing elements in available vertical space.

We have modified the DOM of each SVG graphic to display the graphics responsively, meaning they will shrink and grow to the available viewport. This was achieved by adding a ‘preserveAspectRatio’ attribute to the value of 'xMinYMin meet' on each svg root element. The effect is a web page that modifies the size of the graphics according to the device window.

### 5.3 SVG Graphic Parser
Under the tags of each graphic is a ‘deconstruct’ link. This link will run the parseSVG function. The parseSVG function takes the SVG code and makes it into a domXPath object so the program can use xpath (“//*”) to retrieve all elements under the root svg element, and then creates a DOMDocument object so a select group of shapes (rect, circle, line, ellipse, polygon, polyline, path) can be traversed and parsed. The shapes are then displayed at the bottom of the page, with its respective SVG code available on click. Please note: sometimes a SVG will have shapes, but they will not render because the element is dependent on other parts of the code.

6. ACKNOWLEDGMENTS
---------------------
Thank you to the W3C SVG Working Group for their ongoing development and extending of SVG specifications to foster more integration with HTML, CSS, and the DOM.

Thank you to David DeSandro for developing and sharing MIT’s Masonry library to overcome CSS’s float rigidity.


7. REFERENCES
---------------------
1.  Schneider, Daniel, K. 2013. Using SVG with HTML5 Tutorial. EduTech Wiki. URL= http://edutechwiki.unige.ch/en/Using_SVG_with_HTML5_tutorial.

2.  Cauhepe, Pascal. 2000. SVG into Liquid Layout or Responsive Web Design. QRCodes. URL= http://soqr.fr/testsvg/embed-svg-liquid-layout-responsive-web-design.php.

3.  Refsnes Data. 1999-2013. PHP XML DOM. w3schools.com. URL= http://www.w3schools.com/php/php_xml_dom.asp.
