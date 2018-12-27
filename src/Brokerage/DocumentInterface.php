<?php
namespace CFX\Brokerage;

interface DocumentInterface extends \CFX\JsonApi\ResourceInterface
{
    /**
     * Get the document's user-specified label
     *
     * @return string|null
     */
    public function getLabel();

    /**
     * Get the document's type
     *
     * Type will be one of the valid types specified in the class
     *
     * @return string|null
     */
    public function getType();

    /**
     * Get the document's URL
     *
     * @return string|null
     */
    public function getUrl();

    /**
     * Get the document's status
     *
     * Status will be one of the valid statuses specified in the class
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Get any notes about the document
     *
     * This is to be used to communicate why a document may have been rejected and what else the user
     * can or needs to do.
     *
     * @return string|null
     */
    public function getNotes();

    /**
     * Get the document's associated legal entity
     *
     * This field is for compatibility with the old system model. In the future, documents will be associated with
     * legal entities through the LegalEntity model and not directly via the Document model. For now, though, LegalEntity
     * is required for documents of type `id`.
     *
     * @return LegalEntityInterface|null
     */
    public function getLegalEntity();

    /**
     * Get the document's associated order intent
     *
     * This field is for compatibility with the old system model. In the future, documents will be associated with
     * order intents through the OrderIntent model and not directly via the Document model. For now, though, OrderIntent
     * is required for documents of type `agreement` and `ownership`.
     *
     * @return OrderIntentInterface|null
     */
    public function getOrderIntent();



    /**
     * Set the document's user-specified label
     *
     * @param string|null $val
     * @return static
     */
    public function setLabel($val);

    /**
     * Set the document's type
     * 
     * @see \CFX\Brokerage\DocumentInterface::getType()
     *
     * @param string|null $val
     * @return static
     */
    public function setType($val);

    /**
     * Set the document's URL
     *
     * @param string|null $val
     * @return static
     */
    public function setUrl($val);

    /**
     * Set the document's status
     * 
     * @see \CFX\Brokerage\DocumentInterface::getStatus()
     *
     * @param string|null $val
     * @return static
     */
    public function setStatus($val);

    /**
     * Set the document's notes
     * 
     * @see \CFX\Brokerage\DocumentInterface::getNotes()
     *
     * @param string|null $val
     * @return static
     */
    public function setNotes($val);

    /**
     * Set the document's associated LegalEntity
     * 
     * @see \CFX\Brokerage\DocumentInterface::getLegalEntity()
     *
     * @param LegalEntityInterface|null $val
     * @return static
     */
    public function setLegalEntity(LegalEntityInterface $val = null);

    /**
     * Set the document's associated OrderIntent
     * 
     * @see \CFX\Brokerage\DocumentInterface::getOrderIntent()
     *
     * @param OrderIntentInterface|null $val
     * @return static
     */
    public function setOrderIntent(OrderIntentInterface $val = null);
}
