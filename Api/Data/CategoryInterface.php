<?php

namespace Steampfli\Agenda\Api\Data;

interface CategoryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID    = 'entity_id';
    const TITLE        = 'identifier';
    const UPDATED_AT   = 'updated_at';
    const CREATED_AT   = 'created_at';
    const DESCRIPTION  = 'description';
    /**#@-*/


    /**
     * Get Title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get Content
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

//    /**
//     * Set Title
//     *
//     * @param string $title
//     * @return $this
//     */
//    public function setTitle($title);
//
//    /**
//     * Set Content
//     *
//     * @param string $content
//     * @return $this
//     */
//    public function setContent($content);
//
//    /**
//     * Set Crated At
//     *
//     * @param int $createdAt
//     * @return $this
//     */
//    public function setCreatedAt($createdAt);
//
//    /**
//     * Set ID
//     *
//     * @param int $id
//     * @return $this
//     */
//    public function setId($id);
}
