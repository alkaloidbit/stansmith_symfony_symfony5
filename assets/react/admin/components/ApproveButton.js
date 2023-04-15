import * as React from 'react';
import { useUpdate, useNotify, useRedirect, useRecordContext, Button } from 'react-admin';

const ApproveButton = () => {
    const record = useRecordContext();
    const notify = useNotify();
    const redirect = useRedirect();
    const [approve, { isLoading }] = useUpdate(
        'comments',
        { id: record.id, data: { isApproved: true } },
        {
            onSuccess: (data) => {
                // success side effects go here
                redirect('/comments');
                notify('Comment approved');
            },
            onError: (error) => {
                // failure side effects go here 
                notify(`Comment approval error: ${error.message}`, { type: 'error' });
            },
        }
    );
    
    return <Button label="Approve" onClick={() => approve()} disabled={isLoading} />;
};

export default (ApproveButton);
