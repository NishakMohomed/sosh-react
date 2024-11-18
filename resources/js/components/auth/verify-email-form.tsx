import { router, useForm } from '@inertiajs/react';

import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { FormEventHandler } from 'react';

export function VerifyEmailForm({ status }: { status?: string }) {
    const { post, processing } = useForm({});

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('verification.send'));
    };

    return (
        <Card className="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle className="text-2xl">Email verification</CardTitle>
                <CardDescription>
                    Thanks for signing up! Please verify your email using the
                    link we sent, or request a new one if needed
                </CardDescription>
            </CardHeader>
            <CardContent>
                {status === 'verification-link-sent' && (
                    <div className="grid gap-4">
                        <div className="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                            A new verification link has been sent to your email.
                        </div>
                    </div>
                )}
            </CardContent>
            <form onSubmit={submit}>
                <CardFooter className="flex justify-between">
                    <Button
                        variant={'outline'}
                        type="button"
                        onClick={() => router.post(route('logout'))}
                        disabled={processing}
                    >
                        Log out
                    </Button>
                    <Button type="submit" disabled={processing}>
                        Resend verification email
                    </Button>
                </CardFooter>
                {/* <div className="mt-4 text-center text-sm">
                    <Link
                        href={route('logout')}
                        method="post"
                        className="underline"
                    >
                        Log out
                    </Link>
                </div> */}
            </form>
        </Card>
    );
}
