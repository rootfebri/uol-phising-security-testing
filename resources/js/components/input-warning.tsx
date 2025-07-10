export default ({ message }: { message?: string }) => {
    if (!message) {
        return null;
    }
    return (
        <p className="flex items-center gap-2 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                <g transform="translate(-938.998 -852)">
                    <path
                        id="icone-alerta-informacao"
                        d="M12.375,3.375a9,9,0,1,0,9,9A9,9,0,0,0,12.375,3.375ZM13.2,16.529H11.544V10.294H13.2Zm-.826-6.914a.864.864,0,1,1,.9-.865A.867.867,0,0,1,12.371,9.614Z"
                        transform="translate(935.623 848.625)"
                        fill="#ecbd20"
                    ></path>
                </g>
            </svg>
            <span>{message}</span>
        </p>
    );
};
