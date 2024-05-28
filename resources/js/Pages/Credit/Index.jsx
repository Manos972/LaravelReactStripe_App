import AuhenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import {Head} from "@inertiajs/react";
import CreditsPricingCards from "@/Components/CreditsPricingCards.jsx";


export default function Index({auth, features, packages, success, error}) {
    const availaibleCredits = auth.user.availaible_credits;

    return (
        <AuhenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-grey-800 dark:text-gray-200 leading-tight">
                </h2>
            }
        >
            <Head title='Feature 1'/>
            <div className="py-12">
            <div className="my-12 mx-auto sm:px-6 lg:px-8">
                    {success &&
                        <div className="mb-3 py-3 px-5 rounded text-white bg-emerald-600 text-xl">
                            {success}
                        </div>
                    }
                    {error &&
                        <div className="mb-3 py-3 px-5 rounded text-white bg-red-600 text-xl">
                            {error}
                        </div>
                    }
                <div className="bg-white dark:bg-grey-800 overflow-hidden shadow-sm sm:rounded-lg relative">
                    <div className="flex flex-col gap-3 items-center p-4">
                          <h3 className="text-black text-2xl">
                              Vous avez {availaibleCredits} credits ;)
                          </h3>
                    </div>
                </div>
                <CreditsPricingCards packages={packages.data} features={features.data}>

                </CreditsPricingCards>
            </div>
            </div>
        </AuhenticatedLayout>
    );
}
