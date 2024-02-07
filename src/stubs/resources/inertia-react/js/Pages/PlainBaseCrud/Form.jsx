import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, useForm } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import InputError from "@/Components/InputError";
import TextInput from "@/Components/TextInput";
import InputLabel from "@/Components/InputLabel";
import SecondaryButton from "@/Components/SecondaryButton";

function Form({ auth, item }) {
  const {
    data,
    setData,
    errors,
    put,
    reset,
    post,
    processing,
    recentlySuccessful,
  } = useForm(item || {});

  const baseUrl = "model";

  const submit = () => {
    e.preventDefault();

    if (data.id) {
      put(route(`${baseUrl}.update`, data.id), {
        preserveScroll: true,
        onSuccess: () => reset(),
      });
    } else {
      post(route(`${baseUrl}.store`), {
        preserveScroll: true,
        onSuccess: () => reset(),
      });
    }
  };

  const handleChange = (e) => {
    setData(e.target.name, e.target.value);
  };
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
        <Head title="PageTitle Form" />

        <div className="py-5">
          <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form onSubmit={submit} className="mt-6 space-y-6">
              <div>
                <InputLabel htmlFor="name" value="Name" />
                <TextInput
                  name="name"
                  id="name"
                  className="mt-1 block w-full"
                  value={data.name}
                  onChange={handleChange}
                  required
                  isFocused
                  autoComplete="name"
                  type="text"
                />
                <InputError className="mt-2" message={errors.name} />
              </div>

              <div className="my-5">
                <PrimaryButton className="mr-2" onClick={submit}>
                  Submit
                </PrimaryButton>
                <SecondaryButton
                  onClick={() => router.visit(route(`${baseUrl}.index`))}
                >
                  Cancel
                </SecondaryButton>
              </div>
            </form>
          </div>
        </div>
      </AuthenticatedLayout>
    </div>
  );
}

export default Form;
