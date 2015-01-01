(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '    <ul>                <li data-name="namespace:WebSyndication" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="WebSyndication.html">WebSyndication</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="namespace:WebSyndication_Abstracts" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="WebSyndication/Abstracts.html">Abstracts</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="class:WebSyndication_Abstracts_ItemInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/ItemInterface.html">ItemInterface</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Abstracts_ItemsContainerInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/ItemsContainerInterface.html">ItemsContainerInterface</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Abstracts_ParserInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/ParserInterface.html">ParserInterface</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Abstracts_ReaderInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/ReaderInterface.html">ReaderInterface</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Abstracts_SimpleObject" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/SimpleObject.html">SimpleObject</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Abstracts_StdClass" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/StdClass.html">StdClass</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Abstracts_XMLDataObject" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/XMLDataObject.html">XMLDataObject</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Abstracts_XMLObject" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/XMLObject.html">XMLObject</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Abstracts_XMLObjectsCollection" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebSyndication/Abstracts/XMLObjectsCollection.html">XMLObjectsCollection</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:WebSyndication_Feed" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebSyndication/Feed.html">Feed</a>                    </div>                </li>                            <li data-name="class:WebSyndication_FeedCachable" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebSyndication/FeedCachable.html">FeedCachable</a>                    </div>                </li>                            <li data-name="class:WebSyndication_FeedsCollection" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebSyndication/FeedsCollection.html">FeedsCollection</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Helper" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebSyndication/Helper.html">Helper</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Item" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebSyndication/Item.html">Item</a>                    </div>                </li>                            <li data-name="class:WebSyndication_ItemsCollection" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebSyndication/ItemsCollection.html">ItemsCollection</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Parser" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebSyndication/Parser.html">Parser</a>                    </div>                </li>                            <li data-name="class:WebSyndication_Renderer" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebSyndication/Renderer.html">Renderer</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    {"type": "Namespace", "link": "WebSyndication.html", "name": "WebSyndication", "doc": "Namespace WebSyndication"},{"type": "Namespace", "link": "WebSyndication/Abstracts.html", "name": "WebSyndication\\Abstracts", "doc": "Namespace WebSyndication\\Abstracts"},
            {"type": "Interface", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/ItemInterface.html", "name": "WebSyndication\\Abstracts\\ItemInterface", "doc": "&quot;Interface for syndication item(s)&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ItemInterface", "fromLink": "WebSyndication/Abstracts/ItemInterface.html", "link": "WebSyndication/Abstracts/ItemInterface.html#method_getXmlValue", "name": "WebSyndication\\Abstracts\\ItemInterface::getXmlValue", "doc": "&quot;\n&quot;"},
            
            {"type": "Interface", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/ItemsContainerInterface.html", "name": "WebSyndication\\Abstracts\\ItemsContainerInterface", "doc": "&quot;Interface for object containing syndication items&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ItemsContainerInterface", "fromLink": "WebSyndication/Abstracts/ItemsContainerInterface.html", "link": "WebSyndication/Abstracts/ItemsContainerInterface.html#method___toString", "name": "WebSyndication\\Abstracts\\ItemsContainerInterface::__toString", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ItemsContainerInterface", "fromLink": "WebSyndication/Abstracts/ItemsContainerInterface.html", "link": "WebSyndication/Abstracts/ItemsContainerInterface.html#method_getTagItem", "name": "WebSyndication\\Abstracts\\ItemsContainerInterface::getTagItem", "doc": "&quot;\n&quot;"},
            
            {"type": "Interface", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/ParserInterface.html", "name": "WebSyndication\\Abstracts\\ParserInterface", "doc": "&quot;Interface for syndication item(s) parser&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ParserInterface", "fromLink": "WebSyndication/Abstracts/ParserInterface.html", "link": "WebSyndication/Abstracts/ParserInterface.html#method_parse", "name": "WebSyndication\\Abstracts\\ParserInterface::parse", "doc": "&quot;\n&quot;"},
            
            {"type": "Interface", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/ReaderInterface.html", "name": "WebSyndication\\Abstracts\\ReaderInterface", "doc": "&quot;Interface for syndication feed(s) reader&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ReaderInterface", "fromLink": "WebSyndication/Abstracts/ReaderInterface.html", "link": "WebSyndication/Abstracts/ReaderInterface.html#method_read", "name": "WebSyndication\\Abstracts\\ReaderInterface::read", "doc": "&quot;\n&quot;"},
            
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/ItemInterface.html", "name": "WebSyndication\\Abstracts\\ItemInterface", "doc": "&quot;Interface for syndication item(s)&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ItemInterface", "fromLink": "WebSyndication/Abstracts/ItemInterface.html", "link": "WebSyndication/Abstracts/ItemInterface.html#method_getXmlValue", "name": "WebSyndication\\Abstracts\\ItemInterface::getXmlValue", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/ItemsContainerInterface.html", "name": "WebSyndication\\Abstracts\\ItemsContainerInterface", "doc": "&quot;Interface for object containing syndication items&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ItemsContainerInterface", "fromLink": "WebSyndication/Abstracts/ItemsContainerInterface.html", "link": "WebSyndication/Abstracts/ItemsContainerInterface.html#method___toString", "name": "WebSyndication\\Abstracts\\ItemsContainerInterface::__toString", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ItemsContainerInterface", "fromLink": "WebSyndication/Abstracts/ItemsContainerInterface.html", "link": "WebSyndication/Abstracts/ItemsContainerInterface.html#method_getTagItem", "name": "WebSyndication\\Abstracts\\ItemsContainerInterface::getTagItem", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/ParserInterface.html", "name": "WebSyndication\\Abstracts\\ParserInterface", "doc": "&quot;Interface for syndication item(s) parser&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ParserInterface", "fromLink": "WebSyndication/Abstracts/ParserInterface.html", "link": "WebSyndication/Abstracts/ParserInterface.html#method_parse", "name": "WebSyndication\\Abstracts\\ParserInterface::parse", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/ReaderInterface.html", "name": "WebSyndication\\Abstracts\\ReaderInterface", "doc": "&quot;Interface for syndication feed(s) reader&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\ReaderInterface", "fromLink": "WebSyndication/Abstracts/ReaderInterface.html", "link": "WebSyndication/Abstracts/ReaderInterface.html#method_read", "name": "WebSyndication\\Abstracts\\ReaderInterface::read", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/SimpleObject.html", "name": "WebSyndication\\Abstracts\\SimpleObject", "doc": "&quot;The simplest syndication object entity&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\SimpleObject", "fromLink": "WebSyndication/Abstracts/SimpleObject.html", "link": "WebSyndication/Abstracts/SimpleObject.html#method_setProtocol", "name": "WebSyndication\\Abstracts\\SimpleObject::setProtocol", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\SimpleObject", "fromLink": "WebSyndication/Abstracts/SimpleObject.html", "link": "WebSyndication/Abstracts/SimpleObject.html#method_getProtocol", "name": "WebSyndication\\Abstracts\\SimpleObject::getProtocol", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\SimpleObject", "fromLink": "WebSyndication/Abstracts/SimpleObject.html", "link": "WebSyndication/Abstracts/SimpleObject.html#method_setVersion", "name": "WebSyndication\\Abstracts\\SimpleObject::setVersion", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\SimpleObject", "fromLink": "WebSyndication/Abstracts/SimpleObject.html", "link": "WebSyndication/Abstracts/SimpleObject.html#method_getVersion", "name": "WebSyndication\\Abstracts\\SimpleObject::getVersion", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\SimpleObject", "fromLink": "WebSyndication/Abstracts/SimpleObject.html", "link": "WebSyndication/Abstracts/SimpleObject.html#method_setNamespaces", "name": "WebSyndication\\Abstracts\\SimpleObject::setNamespaces", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\SimpleObject", "fromLink": "WebSyndication/Abstracts/SimpleObject.html", "link": "WebSyndication/Abstracts/SimpleObject.html#method_getNamespaces", "name": "WebSyndication\\Abstracts\\SimpleObject::getNamespaces", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\SimpleObject", "fromLink": "WebSyndication/Abstracts/SimpleObject.html", "link": "WebSyndication/Abstracts/SimpleObject.html#method_getNamespace", "name": "WebSyndication\\Abstracts\\SimpleObject::getNamespace", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\SimpleObject", "fromLink": "WebSyndication/Abstracts/SimpleObject.html", "link": "WebSyndication/Abstracts/SimpleObject.html#method_hasNamespace", "name": "WebSyndication\\Abstracts\\SimpleObject::hasNamespace", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/StdClass.html", "name": "WebSyndication\\Abstracts\\StdClass", "doc": "&quot;A specific standard class definition&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\StdClass", "fromLink": "WebSyndication/Abstracts/StdClass.html", "link": "WebSyndication/Abstracts/StdClass.html#method_hasAttribute", "name": "WebSyndication\\Abstracts\\StdClass::hasAttribute", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\StdClass", "fromLink": "WebSyndication/Abstracts/StdClass.html", "link": "WebSyndication/Abstracts/StdClass.html#method___toString", "name": "WebSyndication\\Abstracts\\StdClass::__toString", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\StdClass", "fromLink": "WebSyndication/Abstracts/StdClass.html", "link": "WebSyndication/Abstracts/StdClass.html#method_getTagItem", "name": "WebSyndication\\Abstracts\\StdClass::getTagItem", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/XMLDataObject.html", "name": "WebSyndication\\Abstracts\\XMLDataObject", "doc": "&quot;The simplest syndication object entity with XML data and a set of data&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLDataObject", "fromLink": "WebSyndication/Abstracts/XMLDataObject.html", "link": "WebSyndication/Abstracts/XMLDataObject.html#method_addData", "name": "WebSyndication\\Abstracts\\XMLDataObject::addData", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLDataObject", "fromLink": "WebSyndication/Abstracts/XMLDataObject.html", "link": "WebSyndication/Abstracts/XMLDataObject.html#method_setData", "name": "WebSyndication\\Abstracts\\XMLDataObject::setData", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLDataObject", "fromLink": "WebSyndication/Abstracts/XMLDataObject.html", "link": "WebSyndication/Abstracts/XMLDataObject.html#method_getData", "name": "WebSyndication\\Abstracts\\XMLDataObject::getData", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLDataObject", "fromLink": "WebSyndication/Abstracts/XMLDataObject.html", "link": "WebSyndication/Abstracts/XMLDataObject.html#method_get", "name": "WebSyndication\\Abstracts\\XMLDataObject::get", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLDataObject", "fromLink": "WebSyndication/Abstracts/XMLDataObject.html", "link": "WebSyndication/Abstracts/XMLDataObject.html#method_set", "name": "WebSyndication\\Abstracts\\XMLDataObject::set", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLDataObject", "fromLink": "WebSyndication/Abstracts/XMLDataObject.html", "link": "WebSyndication/Abstracts/XMLDataObject.html#method___get", "name": "WebSyndication\\Abstracts\\XMLDataObject::__get", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLDataObject", "fromLink": "WebSyndication/Abstracts/XMLDataObject.html", "link": "WebSyndication/Abstracts/XMLDataObject.html#method___set", "name": "WebSyndication\\Abstracts\\XMLDataObject::__set", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/XMLObject.html", "name": "WebSyndication\\Abstracts\\XMLObject", "doc": "&quot;The simplest syndication object entity with XML data&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObject", "fromLink": "WebSyndication/Abstracts/XMLObject.html", "link": "WebSyndication/Abstracts/XMLObject.html#method_setXml", "name": "WebSyndication\\Abstracts\\XMLObject::setXml", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObject", "fromLink": "WebSyndication/Abstracts/XMLObject.html", "link": "WebSyndication/Abstracts/XMLObject.html#method_getXml", "name": "WebSyndication\\Abstracts\\XMLObject::getXml", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObject", "fromLink": "WebSyndication/Abstracts/XMLObject.html", "link": "WebSyndication/Abstracts/XMLObject.html#method_exists", "name": "WebSyndication\\Abstracts\\XMLObject::exists", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication\\Abstracts", "fromLink": "WebSyndication/Abstracts.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection", "doc": "&quot;A collection helper for XML objects&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method___construct", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method___toString", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::__toString", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_getTagItem", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::getTagItem", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_setCollection", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::setCollection", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_getCollection", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::getCollection", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_add", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::add", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_extractCollection", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::extractCollection", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_current", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::current", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_key", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::key", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_next", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::next", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_rewind", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::rewind", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_valid", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::valid", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_previous", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::previous", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_exists", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::exists", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Abstracts\\XMLObjectsCollection", "fromLink": "WebSyndication/Abstracts/XMLObjectsCollection.html", "link": "WebSyndication/Abstracts/XMLObjectsCollection.html#method_count", "name": "WebSyndication\\Abstracts\\XMLObjectsCollection::count", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication", "fromLink": "WebSyndication.html", "link": "WebSyndication/Feed.html", "name": "WebSyndication\\Feed", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method___construct", "name": "WebSyndication\\Feed::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getRawXml", "name": "WebSyndication\\Feed::getRawXml", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getChannel", "name": "WebSyndication\\Feed::getChannel", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_hasItems", "name": "WebSyndication\\Feed::hasItems", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getItemsCount", "name": "WebSyndication\\Feed::getItemsCount", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getItems", "name": "WebSyndication\\Feed::getItems", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getItemById", "name": "WebSyndication\\Feed::getItemById", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getItemsCategories", "name": "WebSyndication\\Feed::getItemsCategories", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getItem", "name": "WebSyndication\\Feed::getItem", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getItemsCollection", "name": "WebSyndication\\Feed::getItemsCollection", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getItemsCollectionByCategorie", "name": "WebSyndication\\Feed::getItemsCollectionByCategorie", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_setFeedUrl", "name": "WebSyndication\\Feed::setFeedUrl", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getFeedUrl", "name": "WebSyndication\\Feed::getFeedUrl", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_setFeedName", "name": "WebSyndication\\Feed::setFeedName", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getFeedName", "name": "WebSyndication\\Feed::getFeedName", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method___toString", "name": "WebSyndication\\Feed::__toString", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_getTagItem", "name": "WebSyndication\\Feed::getTagItem", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_read", "name": "WebSyndication\\Feed::read", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Feed", "fromLink": "WebSyndication/Feed.html", "link": "WebSyndication/Feed.html#method_parse", "name": "WebSyndication\\Feed::parse", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication", "fromLink": "WebSyndication.html", "link": "WebSyndication/FeedCachable.html", "name": "WebSyndication\\FeedCachable", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method___construct", "name": "WebSyndication\\FeedCachable::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_read", "name": "WebSyndication\\FeedCachable::read", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_setCacheKey", "name": "WebSyndication\\FeedCachable::setCacheKey", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_getCacheKey", "name": "WebSyndication\\FeedCachable::getCacheKey", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_getCacheDirname", "name": "WebSyndication\\FeedCachable::getCacheDirname", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_buildCacheKey", "name": "WebSyndication\\FeedCachable::buildCacheKey", "doc": "&quot;Get the key of the current cached item&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_isCached", "name": "WebSyndication\\FeedCachable::isCached", "doc": "&quot;Test if an item is already cached and if its cache is still valid&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_getCache", "name": "WebSyndication\\FeedCachable::getCache", "doc": "&quot;Get a cache content for an item&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_setCache", "name": "WebSyndication\\FeedCachable::setCache", "doc": "&quot;Set a cache content for an item&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedCachable", "fromLink": "WebSyndication/FeedCachable.html", "link": "WebSyndication/FeedCachable.html#method_invalidateCache", "name": "WebSyndication\\FeedCachable::invalidateCache", "doc": "&quot;Clear a cache content for an item&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication", "fromLink": "WebSyndication.html", "link": "WebSyndication/FeedsCollection.html", "name": "WebSyndication\\FeedsCollection", "doc": "&quot;The global Feeds collection&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method___construct", "name": "WebSyndication\\FeedsCollection::__construct", "doc": "&quot;Construction of a collection&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_read", "name": "WebSyndication\\FeedsCollection::read", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getFeedItemIndex", "name": "WebSyndication\\FeedsCollection::getFeedItemIndex", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getFeedById", "name": "WebSyndication\\FeedsCollection::getFeedById", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getItemById", "name": "WebSyndication\\FeedsCollection::getItemById", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getFeedsRegistry", "name": "WebSyndication\\FeedsCollection::getFeedsRegistry", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getFeed", "name": "WebSyndication\\FeedsCollection::getFeed", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_forceRefresh", "name": "WebSyndication\\FeedsCollection::forceRefresh", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getItemsCount", "name": "WebSyndication\\FeedsCollection::getItemsCount", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getItems", "name": "WebSyndication\\FeedsCollection::getItems", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getItemsCategories", "name": "WebSyndication\\FeedsCollection::getItemsCategories", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\FeedsCollection", "fromLink": "WebSyndication/FeedsCollection.html", "link": "WebSyndication/FeedsCollection.html#method_getItemsCollectionByCategorie", "name": "WebSyndication\\FeedsCollection::getItemsCollectionByCategorie", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication", "fromLink": "WebSyndication.html", "link": "WebSyndication/Helper.html", "name": "WebSyndication\\Helper", "doc": "&quot;Helper class for WebSyndication library&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_setOptions", "name": "WebSyndication\\Helper::setOptions", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_setOption", "name": "WebSyndication\\Helper::setOption", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getOption", "name": "WebSyndication\\Helper::getOption", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getTemplate", "name": "WebSyndication\\Helper::getTemplate", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getClass", "name": "WebSyndication\\Helper::getClass", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getSpecifications", "name": "WebSyndication\\Helper::getSpecifications", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_readProtocol", "name": "WebSyndication\\Helper::readProtocol", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_readVersion", "name": "WebSyndication\\Helper::readVersion", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_readNamespaces", "name": "WebSyndication\\Helper::readNamespaces", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_findTagByCommonName", "name": "WebSyndication\\Helper::findTagByCommonName", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getContent", "name": "WebSyndication\\Helper::getContent", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getAttribute", "name": "WebSyndication\\Helper::getAttribute", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getAttributesAsArray", "name": "WebSyndication\\Helper::getAttributesAsArray", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getFilename", "name": "WebSyndication\\Helper::getFilename", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_encodeStringToId", "name": "WebSyndication\\Helper::encodeStringToId", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getSecuredString", "name": "WebSyndication\\Helper::getSecuredString", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_renderView", "name": "WebSyndication\\Helper::renderView", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_isImage", "name": "WebSyndication\\Helper::isImage", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_getImageSize", "name": "WebSyndication\\Helper::getImageSize", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Helper", "fromLink": "WebSyndication/Helper.html", "link": "WebSyndication/Helper.html#method_imageResize", "name": "WebSyndication\\Helper::imageResize", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication", "fromLink": "WebSyndication.html", "link": "WebSyndication/Item.html", "name": "WebSyndication\\Item", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method___construct", "name": "WebSyndication\\Item::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_setType", "name": "WebSyndication\\Item::setType", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getType", "name": "WebSyndication\\Item::getType", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_setName", "name": "WebSyndication\\Item::setName", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getName", "name": "WebSyndication\\Item::getName", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_setXmlValue", "name": "WebSyndication\\Item::setXmlValue", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getXmlValue", "name": "WebSyndication\\Item::getXmlValue", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_setSettings", "name": "WebSyndication\\Item::setSettings", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getSettings", "name": "WebSyndication\\Item::getSettings", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_hasSetting", "name": "WebSyndication\\Item::hasSetting", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getSetting", "name": "WebSyndication\\Item::getSetting", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_exists", "name": "WebSyndication\\Item::exists", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_setAttributes", "name": "WebSyndication\\Item::setAttributes", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getAttributes", "name": "WebSyndication\\Item::getAttributes", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_hasAttribute", "name": "WebSyndication\\Item::hasAttribute", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getAttribute", "name": "WebSyndication\\Item::getAttribute", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_parse", "name": "WebSyndication\\Item::parse", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method___toString", "name": "WebSyndication\\Item::__toString", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getTagItem", "name": "WebSyndication\\Item::getTagItem", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Item", "fromLink": "WebSyndication/Item.html", "link": "WebSyndication/Item.html#method_getHtml", "name": "WebSyndication\\Item::getHtml", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication", "fromLink": "WebSyndication.html", "link": "WebSyndication/ItemsCollection.html", "name": "WebSyndication\\ItemsCollection", "doc": "&quot;The collection handler for items&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\ItemsCollection", "fromLink": "WebSyndication/ItemsCollection.html", "link": "WebSyndication/ItemsCollection.html#method___construct", "name": "WebSyndication\\ItemsCollection::__construct", "doc": "&quot;Construction of a collection&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\ItemsCollection", "fromLink": "WebSyndication/ItemsCollection.html", "link": "WebSyndication/ItemsCollection.html#method_read", "name": "WebSyndication\\ItemsCollection::read", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\ItemsCollection", "fromLink": "WebSyndication/ItemsCollection.html", "link": "WebSyndication/ItemsCollection.html#method_getItemsCount", "name": "WebSyndication\\ItemsCollection::getItemsCount", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\ItemsCollection", "fromLink": "WebSyndication/ItemsCollection.html", "link": "WebSyndication/ItemsCollection.html#method_getItems", "name": "WebSyndication\\ItemsCollection::getItems", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\ItemsCollection", "fromLink": "WebSyndication/ItemsCollection.html", "link": "WebSyndication/ItemsCollection.html#method_getItemsCategories", "name": "WebSyndication\\ItemsCollection::getItemsCategories", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\ItemsCollection", "fromLink": "WebSyndication/ItemsCollection.html", "link": "WebSyndication/ItemsCollection.html#method_getItemsCollectionByCategorie", "name": "WebSyndication\\ItemsCollection::getItemsCollectionByCategorie", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication", "fromLink": "WebSyndication.html", "link": "WebSyndication/Parser.html", "name": "WebSyndication\\Parser", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Parser", "fromLink": "WebSyndication/Parser.html", "link": "WebSyndication/Parser.html#method___construct", "name": "WebSyndication\\Parser::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Parser", "fromLink": "WebSyndication/Parser.html", "link": "WebSyndication/Parser.html#method_setFeed", "name": "WebSyndication\\Parser::setFeed", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Parser", "fromLink": "WebSyndication/Parser.html", "link": "WebSyndication/Parser.html#method_getFeed", "name": "WebSyndication\\Parser::getFeed", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Parser", "fromLink": "WebSyndication/Parser.html", "link": "WebSyndication/Parser.html#method_parse", "name": "WebSyndication\\Parser::parse", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Parser", "fromLink": "WebSyndication/Parser.html", "link": "WebSyndication/Parser.html#method_parseTag", "name": "WebSyndication\\Parser::parseTag", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebSyndication", "fromLink": "WebSyndication.html", "link": "WebSyndication/Renderer.html", "name": "WebSyndication\\Renderer", "doc": "&quot;Class to generate an HTML output from each syndication item type&quot;"},
                                                        {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method___construct", "name": "WebSyndication\\Renderer::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method___toString", "name": "WebSyndication\\Renderer::__toString", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method_setLimit", "name": "WebSyndication\\Renderer::setLimit", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method_getLimit", "name": "WebSyndication\\Renderer::getLimit", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method_setOffset", "name": "WebSyndication\\Renderer::setOffset", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method_getOffset", "name": "WebSyndication\\Renderer::getOffset", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method_guessTemplate", "name": "WebSyndication\\Renderer::guessTemplate", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method_render", "name": "WebSyndication\\Renderer::render", "doc": "&quot;Building of a view content including a view file passing it parameters&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method_getDefaultViewParams", "name": "WebSyndication\\Renderer::getDefaultViewParams", "doc": "&quot;Get an array of the default parameters for all views&quot;"},
                    {"type": "Method", "fromName": "WebSyndication\\Renderer", "fromLink": "WebSyndication/Renderer.html", "link": "WebSyndication/Renderer.html#method_getTemplate", "name": "WebSyndication\\Renderer::getTemplate", "doc": "&quot;Get a template file path&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


