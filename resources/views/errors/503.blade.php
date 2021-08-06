<x-error
    code="503"
    message="Service Unavailable"
    description="The server is unable to handle your request due to scheduled maintenance."
    :buttonUrl="url()->current()"
    buttonText="Refresh page"
/>
