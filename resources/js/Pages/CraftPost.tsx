import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function CraftPost() {
    return (
        <AuthenticatedLayout>
            <Head title="Craft Post" />

            {/* Multi step form */}
            <div className="min-h-[100vh] flex-1 bg-muted/50 p-5 md:min-h-min">
                Multi step form
            </div>
        </AuthenticatedLayout>
    );
}
