<?php

namespace Needletail;

use Needletail\Http\Query;

class Bucket
{
    /**
     * The bucket name.
     *
     * @var string
     */
    private $name;

    /**
     * All the parameters that will be send to the API.
     *
     * @var array
     */
    private $params;

    /**
     * An API key associated with all the read functionalities.
     *
     * @var string
     */
    private $read_key;

    /**
     * An API key associated with all the write functionalities.
     *
     * @var string
     */
    private $write_key;

    /**
     * Create a new Bucket.
     *
     * @param  string $name
     * @param  string $read_key
     * @param  string $write_key
     * @return void
     */
    public function __construct(string $name, string $read_key, string $write_key)
    {
        $this->name = $name;

        $this->read_key = $read_key;

        $this->write_key = $write_key;
    }

    /**
     * Perform a search query on the Needletail API.
     *
     * @param  array $params
     * @return NeedletailResult
     */
    public function search(array $params)
    {
        $this->params = $params;

        return Query::execute('search', $this, $this->read_key);
    }

    /**
     * Perform an aggregated search on the Needletail API.
     *
     * @param  array $params
     * @return NeedletailResult
     */
    public function aggregation(array $params)
    {
        $this->params = $params;

        return Query::execute('aggregation', $this, $this->read_key);
    }

    /**
     * Create a new bucket.
     *
     * @return NeedletailResult
     */
    public function createBucket()
    {
        return Query::execute('buckets', $this, $this->write_key);
    }

    /**
     * Clear a bucket of ALL its documents.
     *
     * @return NeedletailResult
     */
    public function truncateBucket()
    {
        return Query::execute('buckets/truncate', $this, $this->write_key, 'put');
    }

    /**
     * Delete a bucket.
     *
     * @return NeedletailResult
     */
    public function deleteBucket()
    {
        return Query::execute('buckets', $this, $this->write_key, 'delete');
    }

    /**
     * Index a given document in the specified bucket.
     *
     * @param  array $document
     * @return NeedletailResult
     */
    public function index(array $document)
    {
        $this->params = $document;

        return Query::execute('documents/index', $this, $this->write_key);
    }

    /**
     * Send documents in bulk to the API to be indexed.
     *
     * @param  array $documents
     * @return NeedletailResult
     */
    public function bulk(array $documents)
    {
        $this->params = $documents;

        return Query::execute('documents/bulk', $this, $this->write_key);
    }

    /**
     * Update an already existing document in the specified bucket.
     *
     * @param  string $document_id
     * @param  array $document
     * @return NeedletailResult
     */
    public function updateDocument(string $document_id, array $document)
    {
        $this->params = $document;

        return Query::execute('documents/update', $this, $this->write_key, 'put', [
            'x-needletail-document-id' => $document_id
        ]);
    }

    /**
     * Delete a document by its identifier.
     *
     * @param  string $document_id
     * @return NeedletailResult
     */
    public function deleteDocument(string $document_id)
    {
        return Query::execute('documents/delete', $this, $this->write_key, 'delete', [
            'x-needletail-document-id' => $document_id
        ]);
    }

    /**
     * Retrieve all the bucket's synonyms
     *
     * @return NeedletailResult
     */
    public function synonyms()
    {
        return Query::execute('synonyms', $this, $this->read_key, 'get');
    }

    /**
     * Create a synonym
     *
     * @param  array|string $synonyms
     * @param  string|null $original
     * @return NeedletailResult
     */
    public function createSynonym($synonyms, string $original = null)
    {
        if ( ! is_array($synonyms) ) {
            $synonyms = [$synonyms];
        }

        $this->params = [
            'synonyms' => $synonyms
        ];

        if ($original !== null) {
            $this->params['original'] = $original;
        }

        return Query::execute('synonyms', $this, $this->write_key, 'post');
    }

    /**
     * Update a synonym
     *
     * @param  string $id
     * @param  array|string $synonyms
     * @param  string|null $original
     * @return NeedletailResult
     */
    public function updateSynonym($id, $synonyms, string $original = null)
    {
        $this->deleteSynonym($id);

        return $this->createSynonym($original, $synonyms);
    }

    /**
     * Delete a synonym
     *
     * @param  $id
     * @return NeedletailResult
     */
    public function deleteSynonym($id)
    {
        $url = 'synonyms/' . $id;

        return Query::execute($url, $this, $this->write_key, 'delete');
    }

    /**
     * Determines whether the buckets exists or not.
     *
     * @return bool
     */
    public function exists()
    {
        $parameters = [
            'settings' => [
                'size' => 1
            ]
        ];

        // If 'time' doesn't exist then the bucket doesn't exist.
        return $this->search($parameters)->time !== null;
    }

    /**
     * Retrieve the bucket's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieve all the bucket parameters.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params ?: [];
    }
}
