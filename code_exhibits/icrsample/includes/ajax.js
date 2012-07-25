function initAJAX(script, fn)
{
    if (navigator.appName == "Microsoft Internet Explorer") {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else {
        http = new XMLHttpRequest();
    }
    http.open("GET", script, true);
    eval("http.onreadystatechange = useHttpResponse_" + fn);
    http.send(null);
}


function getXMLElementList(obj, tag)
{
    var list = new Array();
    var node;
    var coll = obj[0].getElementsByTagName(tag);
    if (coll.length > 0) {
        for (var i = 0; i < coll.length; i++) {
            node = coll.item(i).firstChild;
            list[i] = node ? node.nodeValue : "";
        }
    }
    return list;
}


function getXMLElementValue(obj, tag)
{
    var val;
    var node;
    var coll = obj.getElementsByTagName(tag);
    if (coll.length > 0) {
        node = coll[0].firstChild;
        val = node ? node.nodeValue : "";
    }
    else {
        val = "";
    }
    return val;
}


function getXMLAttributeValue(obj, tag, attrib)
{
    var val;
    var node;
    var coll = obj.getElementsByTagName(tag);
    if (coll.length > 0) {
        val = coll[0].getAttribute(attrib);
    }
    else {
        val = "";
    }
    return val;
}
