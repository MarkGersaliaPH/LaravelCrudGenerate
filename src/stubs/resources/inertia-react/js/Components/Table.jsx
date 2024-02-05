import React from "react";
import DangerButton from "./DangerButton";
import PrimaryButton from "./PrimaryButton";
import { router } from "@inertiajs/react";
import SecondaryButton from "./SecondaryButton";
// import Swal from "sweetalert2";

function Table({ headers, body, actions, additional_action, fromNumber = 1 }) {
    const handleDelete = (id) => {
        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "You won't be able to revert this!",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonColor: "#3085d6",
        //     cancelButtonColor: "#d33",
        //     confirmButtonText: "Yes, delete it!",
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         router.delete(route(actions.destroy, id), {
        //             onSuccess: (page) => {
        //                 Swal.fire(
        //                     "Good job!",
        //                     "Data has been deleted!",
        //                     "success"
        //                 );
        //             },
        //         });
        //     }
        // });

        confirm("You won't be able to revert this!");
        if (confirm) {
            router.delete(route(actions.destroy, id));
        }
    };
    return (
        <div className="w-full overflow-y-auto">
            <table className="items-center justify-center w-full mb-0 align-top border-collapse dark:bg-slate-800 dark:border-white/40 text-slate-500">
                <thead className="align-bottom dark:border-slate-700">
                    <tr className="bg-gray-100 dark:bg-slate-800   dark:border-slate-700 ">
                        <th className="w-10"></th>
                        {headers.map((header, index) => (
                            <th
                                key={index}
                                className="px-6 py-3 font-bold text-left     align-middle bg-transparent   shadow-none  dark:text-slate-500   tracking-none whitespace-nowrap text-slate-400 "
                            >
                                {header}
                            </th>
                        ))} 
                        <th></th>
                    </tr>
                </thead>
                <tbody className="border-t">
                    {body.length ? (
                        body.map((row, rowIndex) => (
                            <tr
                                key={rowIndex}
                                className="border-b hover:bg-gray-50 dark:hover:bg-slate-900 dark:border-slate-700"
                                // className={`${
                                //     rowIndex !== body.length - 1
                                //         ? "border-b dark:border-white/40"
                                //         : ""
                                // }`}
                            >
                                <td className="px-6 py-3 align-middle bg-transparent  whitespace-nowrap shadow-transparent">
                                    {fromNumber + rowIndex}
                                </td>
                                {row.data.map((cell, cellIndex) => (
                                    <td
                                        className="px-6 py-3 align-middle bg-transparent  whitespace-nowrap shadow-transparent"
                                        key={cellIndex}
                                    >
                                        <p className="mb-0   font-semibold leading-normal dark:text-white dark:border-slate-200 dark:opacity-60">
                                            {cell}
                                        </p>
                                    </td>
                                ))}

                                {actions && (
                                    <td className="px-6 py-3 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent gap-2 flex">
                                        {actions.show && (
                                            <SecondaryButton
                                                href={route(
                                                    actions.show,
                                                    row.id
                                                )}
                                            >
                                                View
                                            </SecondaryButton>
                                        )}
                                        {actions.edit && (
                                            <PrimaryButton 
                                            onClick={()=>
                                            router.visit(route(actions.edit,row.id))
                                            }
                                            >
                                                Edit
                                            </PrimaryButton>
                                        )}
                                        {actions.destroy && (
                                            <DangerButton
                                                onClick={() =>
                                                    handleDelete(row.id)
                                                }
                                            >
                                                Delete
                                            </DangerButton>
                                        )}
                                    </td>
                                )}

                                {additional_action && (
                                    <td>{additional_action}</td>
                                )}
                            </tr>
                        ))
                    ) : (
                        <tr>
                            <td
                                colspan={headers.length + 1}
                                className="text-center py-5"
                            >
                                No Result
                            </td>
                            {/* <td className="px-6 py-3 align-middle bg-transparent dark:border-white/40 whitespace-nowrap  shadow-transparent gap-2 flex justify-center" conspan={headers.length}>No Result</td> */}
                        </tr>
                    )}
                </tbody>
            </table>
        </div>
    );
}

export default Table;
