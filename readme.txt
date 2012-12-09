Theme Documentation
http://codex.wordpress.org/Theme_Review#Theme_Documentation



Theme Documentation
Themes are required to provide end-user documentation of any design limitations or extraordinary installation/setup instructions
Themes are recommended to include a readme.txt file, using Plugin readme.txt markdown.
In lieu of a readme.txt file, Themes are recommended to include a changelog, indicating version-to-version Theme changes.
Please be clear about the following in the documentation included with your Theme. The following helps many users over any potential stumbling blocks:

Indicate precisely what your Theme and template files will achieve.
Adhere to the naming conventions of the standard Theme hierarchy.
Indicate deficiencies in your Themes, if any.
Clearly reference any special modifications in comments within the template and stylesheet files. Add comments to modifications, template sections, and CSS styles, especially those which cross template files.
If you have any special requirements, which may include custom Rewrite Rules, or the use of some additional, special templates, images or files, please explicitly state the steps of action a user should take to get your Theme working.
Provide contact information (website or email), if possible, for support information and questions.
It is also recommended, both for standardization and to minimize any risks that may be associated with other file extensions, a readme.txt text file be used for documentation not made in comments within the template and stylesheet files. Other forms of documentation may be included in addition to the readme file at the Theme author's discretion such as "Contextual Help" within the Theme's "option" page(s).


/* ========================================================================== *\
                             Page Structure Outline
   --------------------------------------------------------------------------

    <!DOCTYPE html>
    <html class="no-js">
    <head>
        <meta charset="UTF-8" />
        <title>{wp_title();}</title>
    </head>
    <body class="{get_body_class();}">
    
        <div id="top">
            <div class="wrapper">
                <div class="row-1">
                    <div class="section-1">
    
                        <div id="logo"></div>
    
                    </div>
                    <div class="section-2">
    
                        <div id="nav"></div>
    
                    </div>
                </div>
            </div>
        </div>

        <div id="mid">
            <div class="wrapper">
                <div class="row-1">
                    <div class="section-1">
    
                        <div id="primary">
                            <div id="content"></div>
                            <div id="comments"></div>
                        </div>
    
                    </div>
                    <div class="section-2">
    
                        <div id="secondary">
                            <div id="sidebar-1"></div>
                        </div>
    
                    </div>
                    <div class="section-3">
    
                        <div id="tertiary">
                            <div id="sidebar-2"></div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>

        <div id="low">
            <div class="wrapper">
                <div class="row-1">
                    <div class="section-1"></div>
                    <div class="section-2"></div>
                    <div class="section-3"></div>
                    <div class="section-4"></div>
                </div>
                <div class="row-2">
                    <div class="section-1">
    
                        <div id="colophon"></div>
    
                    </div>
                </div>
            </div>
        </div>

    </body>
    </html>

\* ========================================================================== */