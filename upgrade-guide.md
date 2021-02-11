Non-breaking changes
- Client->initBucket is deprecated use Client->buckets->create instead
    > The name "initBucket" can imply a lot, it used to act like a "findOrCreate", for now it's being mapped to a find and the create method has been pulled loose.

Breaking changes
- Bucket->createBucket is removed use Bucket->create or Client->buckets->create instead, syntax has changed as well
    > Using createBucket is a little double, it may even imply that you are deleting the child bucket of the bucket you have fetched. For this reason we've changed the syntax to either "Client->buckets->create" passing a self initialized Bucket along as the first parameter. An other option is to call "Bucket->create" directly on the self initialized bucket.
- Bucket->deleteBucket is removed use Bucket->destroy or Client->buckets->destroy instead, syntax has changed as well
    > For the same reason as the createBucket we changed this. You can call "Bucket->destroy" directly on a self initialized (as long as you set the index) or fetched bucket, or call "Client->bucket->destroy" passing along the id of the Bucket to destroy.
- Bucket->truncateBucket is removed use Bucket->truncate or Client->buckets->truncate instead, syntax has changed as well
    > Same reason as create- and deleteBucket. Call "Bucket->truncate" directly on a self initialized (as long as you set the index) or a fetched Bucket, or call "Client->buckets->truncate" passing along the id of the bucket.
- Bucket->updateSynonym is removed
    > There is not really a point in updating synonyms, so we removed the method (for now).
- Bucket->deleteSynonym is removed use Bucket->synonyms->destroy instead, syntax has changed as well
    > To go along with the syntax used for creating, destroying and truncating buckets we made the decision to remove this method and replace it with "Bucket->synonyms->destroy", pass along the id of the synonyms.
- Bucket->getSynonym is removed use Bucket->synonyms->find instead, syntax has changed as well
    > For the same reason as changing deleteSynonym we changed this. Use "Bucket->synonyms->find" passing along the id of the synonym to fetch it.
- Bucket->createSynonym is removed use Bucket->synonyms->create instead, syntax has changed as well
    > For the same reason as changing get- and deleteSynonym we changed this. Use "Bucket->synonyms->create" passing along a self initialized Synonym object.
- Bucket->synonyms has been changed, use Bucket->synonyms->all instead
    > For the same reason as changing create-, get- and deleteSynonym we changed this. Use "Bucket->synonyms->all" to fetch all the synonyms for a specific bucket. 
- Alternatives are no longer synonyms, they are callable by using Bucket->alternatives
    > In the past synonyms and alternatives were the "same" thing. We have now separated the 2 due to them being different, all the methods that can be used on synonyms are available for the alternatives as well. "Bucket->alternatives->all", "Bucket->alternatives->create", "Bucket->alternatives->destroy" and "Bucket->alternatives->find".
- Bucket->search is removed use Client->search instead, syntax has changed as well
    > Since searches aren't specifically done on one bucket (the new update allows for searching on multiple buckets with the same query) we moved this method to be directly callable on the Client. This makes it more logical to work with the new functionality.
- Client->batch has been removed use Client->bulk instead, syntax has changed as well
    > The batch method has always been on the client, we changed up the name to be more in line of the actual url being called in the API.
- The initialization of Client has changed, only one API key is required. Write keys can be used for all requests, read keys can only be used for GET requests.
    > It didn't really make any sense to always have to use 2 API keys while only using one per request, which API key is send along with the request is now completely in your hands. As mentioned above, read keys can only be used for GET requests where write keys can be used for any type of request.
- Bucket->deleteDocument is removed use Bucket->documents->destroy, Bucket->bulkDocuments->destroy or Document->destroy
    > To be more in line with the changes we made to buckets, synonyms and alternatives we did the same to documents. You can call "Bucket->documents->destroy" passing along the id of the document to destroy a single document, or call "Bucket->bulkDocuments->destroy" passing along an array of ids to destroy more than one document. Further on you can destroy a document by self initializing it or fetching it and then calling the "destroy" method directly on the document.
- Bucket->index is removed use Bucket->documents->create or Document->create
    > For the same reason as changing deleteDocument and having clear what is being indexed the new method is called "Bucket->documents->create" accepting a document to be indexed, or call the "create" method directly on a self initialized document.
- Bucket->bulk is removed use Bucket->bulkDocuments->create
    > For the same reason as changing index we changed this method as well, making clear what is actually being indexed. Call "Bucket->bulkDocuments->create" passing along an array of documents to index them in bulk.
- Bucket->updateDocument is removed use Bucket->documents->update or Document->update
    > For the same reason as changing the other functions having to do with documents we changed this one as well. Call "Bucket->documents->update" passing along the id and the document itself or call "Document->update" directly on a fetched document to update it.

New features
- Bucket->update is added
    > Since it is possible to update certain settings of a bucket it is now also possible using the API.