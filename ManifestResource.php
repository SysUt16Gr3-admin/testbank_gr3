<?php

/**
 * Class that represent a <resource> element in the manifest containing data that is needed to create the
 * <resource> element in the manifest
 */
class ManifestResource {
    private $identifier;
    private $href;
    private $type;
    private $langstring;
    private $format;
    private $file_href;

    /**
     * ManifestResource constructor.
     * @param $identifier
     * @param $href
     * @param $type
     * @param $langstring
     * @param $format
     * @param $file_href
     */
    public function __construct($identifier, $href, $type, $langstring, $format, $file_href)
    {
        $this->identifier = $identifier;
        $this->href = $href;
        $this->type = $type;
        $this->langstring = $langstring;
        $this->format = $format;
        $this->file_href = $file_href;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getLangstring()
    {
        return $this->langstring;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return mixed
     */
    public function getFileHref()
    {
        return $this->file_href;
    }


}

/*            <resource identifier="resource-item-92563" href="item92563.xml" type="imsqti_item_xmlv2p1">
                <metadata>
                    <imsmd:lom>
                        <imsmd:general>
                            <imsmd:title>
                                <imsmd:langstring xml:lang="en">FillInTheBlankText</imsmd:langstring>
                            </imsmd:title>
                        </imsmd:general>
                        <imsmd:technical>
                            <imsmd:format>text/x-imsqti-item-xml</imsmd:format>
                        </imsmd:technical>
                    </imsmd:lom>
                    <imsqti:qtiMetadata>
                        <imsqti:interactionType>textEntryInteraction</imsqti:interactionType>
                    </imsqti:qtiMetadata>
                </metadata>
                <file href="item92563.xml"/>
            </resource>
         */
