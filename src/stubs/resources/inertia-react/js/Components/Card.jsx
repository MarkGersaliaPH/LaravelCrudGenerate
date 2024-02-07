import React from "react";

export function CardHeader({ title, children, className, titleClass }) {
    return (
        <div
            className={`p-6 border-b dark:border-slate-200 ${className}`}
        >
            <h5
                className={`text-xl font-medium  leading-tight align-middle text-neutral-800 dark:text-neutral-50 ${titleClass}`}
            >
                {title}
            </h5>
            <div className="flex gap-2 ">{children}</div>
        </div>
    );
}
export function CardBody({ title, children, className }) {
    return (
        <div className="p-4">
            <div>{children}</div>
        </div>
    );
}
export function CardFooter({ title, children }) {
    return (
        <div className="flex items-center p-5  justify-between border-t  mt-5">
            <div>{children}</div>
        </div>
    );
}

function Card({ title, children, className, ...props }) {
    return (
        <div  {...props}
        className={` 
            block rounded-lg border  dark:bg-slate-800 bg-white
            ${className}
            `}
        >
            {children}
        </div>
    );
}

export default Card;