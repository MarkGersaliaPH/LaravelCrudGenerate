import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";

function List({ auth, items }) {
  const baseUrl = "model";

  console.log(items);

  return (
    <div>
      <AuthenticatedLayout
        user={auth.user}
        header={
          <h2 className="font-semibold text-xl text-gray-800 leading-tight">
            PageTitle
          </h2>
        }
      >
        <Head title="PageTitle List" />

        <div className="py-5">
          <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {baseUrl && (
              <PrimaryButton
                className="my-5"
                onClick={() => {
                  router.visit(route(`${baseUrl}.create`));
                }}
              >
                Create PageTitle
              </PrimaryButton>
            )}
            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
              <div className=" text-gray-900 border-b pb-5">PageTitle List</div>

              <div>
                <table class="table-auto">
                  <thead>
                    <tr>
                      <th>Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    {items.data.map((item, key) => (
                      <tr>
                        <td>{item.name}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </AuthenticatedLayout>
    </div>
  );
}

export default List;
