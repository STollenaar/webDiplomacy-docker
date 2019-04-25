//Set whether or not to use desktop mode and call it when the client loads the utility JS file.
function setDesktopMode(){
    var toggle = localStorage.getItem("desktopEnabled");
    var toggleElem = document.getElementById('js-desktop-mode');
    if (toggle == "true") {
        changeCSS(false);
        if(toggleElem !== null) {
            toggleElem.innerHTML = "Disable Desktop Mode";
        }
    } else {
        changeCSS(true);
        if(toggleElem !== null) {
            toggleElem.innerHTML = "Enable Desktop Mode";
        }
    }
}
setDesktopMode();

//This is called when a user clicks the Enable/Disabled desktop mode
function toggleDesktopMode(){
    var toggle = localStorage.getItem("desktopEnabled");
    if (toggle == "true") {
        localStorage.setItem("desktopEnabled", false);
    } else {
        localStorage.setItem("desktopEnabled", true);
    }
    setDesktopMode();
}

//Change the CSS documents between Desktop and Mobile Variants
// TRUE = Mobile Included --- FALSE = Desktop Only
function changeCSS(toggle) {
    if(toggle === false) {
        var viewPortTag = document.getElementById("viewport-tag");
        if(viewPortTag !== null) {
            viewPortTag.remove();
        }

        var oldlinkGlobal = document.getElementById("global-css");
        var newlinkGlobal = document.createElement("link");
        newlinkGlobal.setAttribute("rel", "stylesheet");
        newlinkGlobal.setAttribute("type", "text/css");
        newlinkGlobal.setAttribute("id", "global-css");
        newlinkGlobal.setAttribute("href", cssDirectory + "/desktopOnly/global.css?ver=" + cssVersion);
        document.getElementsByTagName("head").item(0).appendChild(newlinkGlobal);

        var oldlinkHome = document.getElementById("home-css");
        var newlinkHome = document.createElement("link");
        newlinkHome.setAttribute("rel", "stylesheet");
        newlinkHome.setAttribute("type", "text/css");
        newlinkHome.setAttribute("id", "home-css");
        newlinkHome.setAttribute("href", cssDirectory + "/desktopOnly/home.css?ver=" + cssVersion);
        document.getElementsByTagName("head").item(0).appendChild(newlinkHome);

        var oldlinkGamePanel = document.getElementById("game-panel-css");
        var newlinkGamePanel = document.createElement("link");
        newlinkGamePanel.setAttribute("rel", "stylesheet");
        newlinkGamePanel.setAttribute("type", "text/css");
        newlinkGamePanel.setAttribute("id", "game-panel-css");
        newlinkGamePanel.setAttribute("href", cssDirectory + "/desktopOnly/gamepanel.css?var=" + cssVersion);
        document.getElementsByTagName("head").item(0).appendChild(newlinkGamePanel);

        newlinkGlobal.onload = function(){
           oldlinkGlobal.remove();
        };
        newlinkHome.onload = function(){
            oldlinkHome.remove();
        };
        newlinkGamePanel.onload = function(){
            oldlinkGamePanel.remove();
        };
    }else{
        var viewPortTag = document.createElement("meta");
        viewPortTag.setAttribute("id", "viewport-tag");
        viewPortTag.setAttribute("name", "viewport");
        viewPortTag.setAttribute("content", "width=device-width, initial-scale=1");
        document.getElementsByTagName("head").item(0).appendChild(viewPortTag);

        var oldlinkGlobal = document.getElementById("global-css");
        if(oldlinkGlobal.getAttribute("href") !== cssDirectory + "/global.css?ver=" + cssVersion) {
            var newlinkGlobal = document.createElement("link");
            newlinkGlobal.setAttribute("rel", "stylesheet");
            newlinkGlobal.setAttribute("type", "text/css");
            newlinkGlobal.setAttribute("id", "global-css");
            newlinkGlobal.setAttribute("href", cssDirectory + "/global.css?ver=" + cssVersion);
            document.getElementsByTagName("head").item(0).appendChild(newlinkGlobal);
            newlinkGlobal.onload = function(){
                oldlinkGlobal.remove();
            };
        }

        var oldlinkHome = document.getElementById("home-css");
        if(oldlinkHome.getAttribute("href") !== cssDirectory + "/home.css?ver=" + cssVersion) {
            var newlinkHome = document.createElement("link");
            newlinkHome.setAttribute("rel", "stylesheet");
            newlinkHome.setAttribute("type", "text/css");
            newlinkHome.setAttribute("id", "home-css");
            newlinkHome.setAttribute("href", cssDirectory + "/home.css?ver=" + cssVersion);
            document.getElementsByTagName("head").item(0).appendChild(newlinkHome);
            newlinkHome.onload = function(){
                oldlinkHome.remove();
            };
        }

        var oldlinkGamePanel = document.getElementById("game-panel-css");
        if(oldlinkGamePanel.getAttribute("href") !== cssDirectory + "/gamepanel.css?var=" + cssVersion) {
            var newlinkGamePanel = document.createElement("link");
            newlinkGamePanel.setAttribute("rel", "stylesheet");
            newlinkGamePanel.setAttribute("type", "text/css");
            newlinkGamePanel.setAttribute("id", "game-panel-css");
            newlinkGamePanel.setAttribute("href", cssDirectory + "/gamepanel.css?var=" + cssVersion);
            document.getElementsByTagName("head").item(0).appendChild(newlinkGamePanel);
            newlinkGamePanel.onload = function(){
                oldlinkGamePanel.remove();
            };
        }
    }
}
