import { Link } from "@inertiajs/react";
import React from "react";
// import { FaChevronLeft, FaChevronRight } from "react-icons/fa";

function Pagination({ items }) {
    return (
        <div className="flex items-center justify-between gap-5 bg-white px-4 py-3 sm:px-6">
            {/* <div className="flex flex-1 justify-between sm:hidden">
                <a
                    href="#"
                    className="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Previous
                </a>
                <a
                    href="#"
                    className="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Next
                </a>
            </div> */}
            <div className="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between mr-auto">
                <div>
                    <p className="text-sm text-gray-700">
                        Showing{" "}
                        <span className="font-medium">{items.from}</span> to{" "}
                        <span className="font-medium">{items.to}</span> of{" "}
                        <span className="font-medium">{items.total}</span>{" "}
                        results
                    </p>
                </div>
            </div>
            {items.total >= 1 && (
                <nav
                    className="isolate inline-flex -space-x-px rounded-md shadow-sm"
                    aria-label="Pagination"
                >
                    <Link
                        href={items.first_page_url}
                        className="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"
                    >
                        <span>First</span>
                    </Link>
                    {items.links.map((link, key) => (
                        <Link
                            href={link.url}
                            aria-current="page"
                            className={`${
                                link.active
                                    ? "relative z-10 inline-flex items-center bg-blue-500 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    : "relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"
                            }`}
                        >
                            <span
                                dangerouslySetInnerHTML={{
                                    __html: link.label,
                                }}
                            ></span>
                        </Link>
                    ))}
                    <Link
                        href={items.last_page_url}
                        className="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"
                    >
                        <span>Last</span>
                    </Link>
                    {/* Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" */}
                </nav>
            )}
        </div>
    );
}

export default Pagination;
